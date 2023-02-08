<?php

namespace Maxim\EasyBundle\Tests\Unit\Queue\Worker\Factory;

use Maxim\EasyBundle\Queue\Worker\Factory\ClientFactory;
use PHPUnit\Framework\TestCase;

class ClientFactoryTest extends TestCase
{
    public function testCreateClientFactoryMethod()
    {
        //TODO:: why need add work server to test client creating
        $factory = new ClientFactory();
        $client = $factory->createClient('172.17.0.1', 4730);
        self::assertInstanceOf(\GearmanClient::class, $client);
    }
}