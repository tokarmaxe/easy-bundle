<?php

namespace Maxim\EasyBundle\Command;

use Maxim\EasyBundle\Queue\Worker\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class GearmanClientCommand extends Command
{
    protected static $defaultName = 'gearman-client-up';

    private Client $client;

    public function configure(): void
    {
        $this->addOption(
            'string',
            's',
            InputOption::VALUE_OPTIONAL,
            'Add to the database this string | example (--string=Hello Monika!)'
        )
            ->setDescription('Adding string to the database')
            ->setHelp('This command adds string to the database');
    }

    public function __construct(Client $client)
    {
        parent::__construct();

        $this->client = $client;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $string = $input->getOption('string');
        $this->client->setHost('172.17.0.1');
        $this->client->setPort(4730);
        $this->client->exec($string);
    }
}
