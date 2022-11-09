<?php

namespace App\Command;

use App\Repository\ArticleRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;

#[AsCommand(
    name: 'app:articles:bank',
    description: './data/articles.yaml file creator from database "article" content.',
)]
class CreateArticlesBankCommand extends Command
{
    public function __construct(
        private ArticleRepository $repository
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $articles = $this->repository->findAll();
        $path = dirname(__DIR__, 2) . '/data/articles.yaml';
        $filesystem = new Filesystem();

        try {
            
            $filesystem->touch($path);
            foreach ($articles as $article) {
                $filesystem->appendToFile($path, '- {' . "\n");
                $filesystem->appendToFile($path, '  title: "' . str_replace('"', '\"', $article->getTitle()) . '"' . ",\n");
                $filesystem->appendToFile($path, '  link: "' . $article->getLink() . '"' . ",\n");
                $filesystem->appendToFile($path, '  source: "' . $article->getSource() . '"' . ",\n");
                $filesystem->appendToFile($path, '  keywords: "' . $article->getKeywords() . '"' . ",\n");
                $filesystem->appendToFile($path, '  creator: "' . $article->getCreator() . '"' . ",\n");
                $filesystem->appendToFile($path, '  imageUrl: "' . $article->getImageUrl() . '"' . ",\n");
                $filesystem->appendToFile($path, '  videoUrl: "' . $article->getVideoUrl() . '"' . ",\n");
                $filesystem->appendToFile($path, '  description: "' . str_replace('"', '\"', $article->getDescription()) . '"' . ",\n");
                $filesystem->appendToFile($path, '  pubDate: "' . $article->getPubDate()?->format('Y-m-d H:i:s') . '"' . ",\n");
                $filesystem->appendToFile($path, '  content: "' . str_replace('"', '\"', $article->getContent()) . '"' . ",\n");
                $filesystem->appendToFile($path, '  country: "' . $article->getCountry() . '"' . ",\n");
                $filesystem->appendToFile($path, '  category: "' . $article->getCategory() . '"' . ",\n");
                $filesystem->appendToFile($path, '  language: "' . $article->getLanguage() . '"' . ",\n");
                $filesystem->appendToFile($path, '  uri: "' . $article->getUri() . '"' . ",\n");
                $filesystem->appendToFile($path, '  published: ' . $article->isPublished() . "\n");
                $filesystem->appendToFile($path, '}' . "\n\n");
            }

        } catch (IOExceptionInterface $exception) {

            $io->error('Something went wrong with creating de articles.yaml file...');
            $io->error($exception->getMessage());
            return Command::FAILURE;
        }

        $io->success('The file ./data/articles.yaml has been created successfully !');

        return Command::SUCCESS;
    }
}
