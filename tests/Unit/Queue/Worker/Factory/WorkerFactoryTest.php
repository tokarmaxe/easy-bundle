<?php

namespace Maxim\EasyBundle\Tests\Unit\Queue\Worker\Factory;

use GearmanJob;
use Maxim\EasyBundle\Queue\Worker\DBWriteHandler;
use Maxim\EasyBundle\Queue\Worker\Factory\WorkerFactory;
use PHPUnit\Framework\TestCase;

class WorkerFactoryTest extends TestCase
{
    public function testCreateWorkerFactoryMethod()
    {
        $gearmanJob = \Mockery::mock(GearmanJob::class);
        $handler = \Mockery::mock(DBWriteHandler::class);
        $handler->shouldReceive('handle')
            ->withArgs([$gearmanJob])
            ->once()
            ->andReturn(true);
        $factory = new WorkerFactory();
        $client = $factory->createworker($handler, 'anyFunctionName', '172.17.0.1', 4730);
        self::assertInstanceOf(\GearmanWorker::class, $client);
    }
}
