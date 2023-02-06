<?php

namespace Maxim\EasyBundle\Command;

use GearmanClient;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GearmanCommand extends Command
{
    protected static $defaultName = 'execute-jobs';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $client = new GearmanClient();
        $client->addServer('172.17.0.1', 4730);
        echo $client->doNormal('writeToDB','hello Monica!');
        return 0;
    }
}