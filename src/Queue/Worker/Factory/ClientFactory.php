<?php

namespace Maxim\EasyBundle\Queue\Worker\Factory;

use GearmanClient;

class ClientFactory
{
    public function createClient($host, $port): GearmanClient
    {
        $client = new GearmanClient();
        $client->addServer($host, $port);
        return $client;
    }
}