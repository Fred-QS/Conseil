<?php

namespace App\Command;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use NewsdataIO\NewsdataApi;
use App\Entity\Article;
use Symfony\Component\Mailer\MailerInterface;
use App\Mail\NewsletterMailer;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class GetArticlesCommand extends Command
{
    private array $languages = ['fr', 'en'];
    protected static $defaultName = 'api:articles';
    protected OutputInterface $output;
    protected InputInterface $input;

    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected ParameterBagInterface $params,
        protected MailerInterface $mailer,
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
            ->addArgument('lang', InputArgument::REQUIRED, 'Articles language (fr or en)')
        ;
    }

    /**
     * @throws TransportExceptionInterface
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $lang = $input->getArgument('lang');

        if ($lang && in_array($lang, $this->languages, true)) {

            $language = ($lang === 'en') ? 'english' : 'french';
            $newsdataApiObj = new NewsdataApi($this->newsdataKey);
            $data = ["language" => $lang, "category" => $this->newsdataCategories];
            $response = $newsdataApiObj->get_latest_news($data);
            dump($response);

            //$email = new NewsletterMailer($this->mailer, $this->entityManager);
            //$email->sendEmail($lang);

            $io->success('All ' . $language . ' articles have been imported');
            return Command::SUCCESS;
        }

        return Command::FAILURE;
    }
}
