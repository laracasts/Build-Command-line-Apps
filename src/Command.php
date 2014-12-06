<?php namespace Acme;

use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Command extends SymfonyCommand {

    /**
     * The wrapper for the database.
     *
     * @var DatabaseAdapter
     */
    protected $database;

    /**
     * Create a new Command instance.
     *
     * @param DatabaseAdapter $database
     */
    public function __construct(DatabaseAdapter $database)
    {
        $this->database = $database;

        parent::__construct();
    }

    /**
     * Show a table of all tasks.
     *
     * @param OutputInterface $output
     * @return mixed
     */
    protected function showTasks(OutputInterface $output)
    {
        if ( ! $tasks = $this->database->fetchAll('tasks'))
        {
            return $output->writeln('<info>No tasks at the moment!</info>');
        }

        $table = new Table($output);

        $table->setHeaders(['Id', 'Description'])
              ->setRows($tasks)
              ->render();
    }

}