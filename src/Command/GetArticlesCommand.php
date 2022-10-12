<?php

namespace App\Command;

use App\SeoStrategy\Diffusion;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use NewsdataIO\NewsdataApi;
use App\Entity\Article;
use Symfony\Component\Mailer\MailerInterface;
use App\Mail\NewsletterMailer;
use App\Mail\ErrorImportArticleEmail;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\SeoStrategy\Formater;

#[AsCommand(
    name: 'api:articles',
)]
class GetArticlesCommand extends Command
{
    protected OutputInterface $output;
    protected InputInterface $input;
    private array $articles = [];

    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected MailerInterface $mailer,
        private SluggerInterface $slugger,
        protected ParameterBagInterface $params,
        protected string $newsdataUrl,
        protected string $newsdataKey,
        protected string $newsdataCategories
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Import articles from NEWSDATA.IO')
        ;
    }

    /**
     * @throws TransportExceptionInterface
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->input = $input;
        $this->output = $output;
        $check = 'ok';
        $checkLang = 'French';
        $io = new SymfonyStyle($input, $output);

        $io->title('French articles importation process');
        $check = $this->getArticles('fr');
        $this->articles = [];

        if ($check === 'ok') {
            $checkLang = 'English';
            $io->title('English articles importation process');
            $check = $this->getArticles('en');
        }

        $diffusion = new Diffusion($this->mailer, $this->entityManager);
        $stt = $diffusion->sendVerifyArticles($check);

        if ($stt === true) {
            $io->success('Articles have been imported');
            $io->success('Articles verification articles have been sent.');
        } else {
            $io->caution($checkLang . ' importation failed: ' . $check);
        }

        return Command::SUCCESS;
    }

    /**
     * @throws Exception
     */
    private function getArticles($lang): string
    {
        $io = new SymfonyStyle($this->input, $this->output);
        $io->progressStart(5);
        $page = 0;
        $cnt = 1;
        while (count($this->articles) <= 5 && $cnt < 100) {
            $newsdataApiObj = new NewsdataApi($this->newsdataKey);
            $data = ["language" => $lang, "category" => $this->newsdataCategories, "page" => $page];
            $articles = $newsdataApiObj->get_latest_news($data);
            if ($articles->status === 'success') {
                foreach ($articles->results as $article) {
                    if ($article->description !== null
                        && $article->image_url !== null
                        && $article->content !== null
                        && strlen($article->content) > 3000) {
                        $oldArticle = $this->entityManager->getRepository(Article::class)->findOneBy(['title' => $article->title]);
                        if ($oldArticle === null) {
                            $this->articles[] = $article;
                            $io->progressAdvance();
                        }
                    }
                }
                $page++;
            } else {
                $io->progressFinish();
                return $articles->results->message;
            }
            $cnt++;
        }
        $this->output->writeln('<comment>  ></comment> <info> ' . ($page + 1) . ' calls have been done.</info>');
        foreach ($this->articles as $newArticle) {

            $formater = new Formater();
            $keywords = $formater->setKeywords($newArticle->content, $lang);
            $content = $formater->setSeoContent($newArticle->content, $keywords);

            $art = new Article();
            $art->setTitle($newArticle->title);
            $slug = strtolower($this->slugger->slug($newArticle->title, '-', $lang));
            $art->setUri($slug);
            $art->setLink($newArticle->link);
            $art->setKeywords($keywords);
            $art->setCreator($newArticle->creator);
            $art->setVideoUrl($newArticle->video_url);
            $art->setDescription($newArticle->description);
            $art->setContent($content);
            $art->setPubDate($newArticle->pubDate);
            $art->setImageUrl($newArticle->image_url);
            $art->setSource($newArticle->source_id);
            $art->setCountry($newArticle->country);
            $art->setCategory($newArticle->category);
            $art->setLanguage($newArticle->language);
            
            $this->entityManager->persist($art);
            $this->entityManager->flush();
        }
        $io->progressFinish();
        return 'ok';
    }
}

