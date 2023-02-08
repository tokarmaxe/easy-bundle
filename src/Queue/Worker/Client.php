<?php

namespace Maxim\EasyBundle\Queue\Worker;

use GearmanClient;
use Maxim\EasyBundle\Queue\Worker\Factory\ClientFactory;

class Client
{
    private ClientFactory $clientFactory;
    private GearmanClient $client;
    private string $host;
    private int $port;

    public function __construct(ClientFactory $clientFactory)
    {
        $this->clientFactory = $clientFactory;
    }

    public function exec($string): string
    {
        $this->init();
        return $this->client->doNormal('writeToDB', $string);
    }

    public function setHost(string $host)
    {
        $this->host = $host;
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function setPort(int $port)
    {
        $this->port = $port;
    }

    public function getPort(): int
    {
        return $this->port;
    }

    public function init()
    {
        $this->client = $this->clientFactory->createClient($this->getHost(), $this->getPort());
    }
}