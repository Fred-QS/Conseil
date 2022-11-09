<?php

namespace App\Command;

use MongoDB\Driver\Exception\CommandException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\ExceptionInterface;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:db:fresh',
    description: 'Rebuild database and load fixtures',
)]
class DataBaseRefreshCommand extends Command
{
    private array $commands = [
        'doctrine:database:drop',
        'doctrine:database:create',
        'doctrine:migrations:migrate',
        'doctrine:fixtures:load'
    ];

    private array $forced = [
        'doctrine:database:drop',
    ];

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        try {

            foreach ($this->commands as $line) {
                $argList = [];
                $command = $this->getApplication()?->find($line);
                if (in_array($line, $this->forced, true)) {
                    $argList['--force'] = true;
                }
                $args = new ArrayInput($argList);
                $args->setInteractive(false);
                $command->run($args, $output);
            }

        } catch (ExceptionInterface $e) {

            $io->error('Something went wrong with DataBase rebuilding...');
            $io->error($e->getMessage());
            return Command::FAILURE;
        }

        $io->success('DataBase has been successfully rebuilt and populated !');

        return Command::SUCCESS;
    }
}
