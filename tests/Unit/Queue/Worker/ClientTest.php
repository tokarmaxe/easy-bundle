<?php

namespace Maxim\EasyBundle\Tests\Unit\Queue\Worker;

use Maxim\EasyBundle\Queue\Worker\Client;
use Maxim\EasyBundle\Queue\Worker\Factory\ClientFactory;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    public function testClientHost()
    {
        $clientFactory = \Mockery::mock(ClientFactory::class);
        $clientFactory->shouldReceive('createClient')
            ->times(1);
        $client = new Client($clientFactory);
        $client->setHost('127.0.0.1');
        self::assertSame('127.0.0.1', $client->getHost());
    }

    public function testClientPort()
    {
        $clientFactory = \Mockery::mock(ClientFactory::class);
        $clientFactory->shouldReceive('createClient')
            ->times(1);
        $client = new Client($clientFactory);
        $client->setPort(4730);
        self::assertSame(4730, $client->getPort());
    }

    public function testClientExecuting()
    {
        $gearmanClient = \Mockery::mock(\GearmanClient::class);
        $gearmanClient->shouldReceive('doNormal')
            ->times(1)
            ->andReturn('Done');
        $clientFactory = \Mockery::mock(ClientFactory::class);
        $clientFactory->shouldReceive('createClient')
            ->times(1)
            ->andReturn($gearmanClient);
        $client = new Client($clientFactory);
        $client->setHost('127.0.0.1');
        $client->setPort(4730);
        $result = $client->exec('SomeString');
        self::assertSame('Done', $result);
    }
}