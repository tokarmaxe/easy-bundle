<?php

namespace Maxim\EasyBundle\Tests\Unit\Queue\Worker\Factory;

use Maxim\EasyBundle\Queue\Worker\DBWriteHandler;
use Maxim\EasyBundle\Queue\Worker\Factory\WorkerFactory;
use PHPUnit\Framework\TestCase;

class WorkerFactoryTest extends TestCase
{
    public function testCreateWorkerFactoryMethod()
    {
        //TODO:: why need add work server to test client creating
        $handler = \Mockery::mock(DBWriteHandler::class);
        $handler->shouldReceive('handle')
            ->times(1);
        $factory = new WorkerFactory();
        $client = $factory->createworker($handler,'anyFunctionName','172.17.0.1', 4730);
        self::assertInstanceOf(\GearmanWorker::class, $client);
    }
}