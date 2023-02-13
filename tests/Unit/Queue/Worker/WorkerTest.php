<?php

namespace Maxim\EasyBundle\Tests\Unit\Queue\Worker;

use GearmanJob;
use GearmanWorker;
use Maxim\EasyBundle\Queue\Worker\DBWriteHandler;
use Maxim\EasyBundle\Queue\Worker\Factory\WorkerFactory;
use Maxim\EasyBundle\Queue\Worker\Worker;
use PHPUnit\Framework\TestCase;

class WorkerTest extends TestCase
{
    public function testWorkerHost()
    {
        $gearmanJob = \Mockery::mock(GearmanJob::class);
        $handler = \Mockery::mock(DBWriteHandler::class);
        $handler->shouldReceive('handle')
            ->withArgs([$gearmanJob])
            ->once()
            ->andReturn(true);
        $workerFactory = \Mockery::mock(WorkerFactory::class);
        $workerFactory->shouldReceive('createWorker')
            ->withArgs(['127.0.0.1', 4730])
            ->once()
            ->andReturn(Worker::class);
        $worker = new Worker($handler, $workerFactory);
        $worker->setHost('127.0.0.1');
        self::assertSame('127.0.0.1', $worker->getHost());
    }

    public function testWorkerPort()
    {
        $gearmanJob = \Mockery::mock(GearmanJob::class);
        $handler = \Mockery::mock(DBWriteHandler::class);
        $handler->shouldReceive('handle')
            ->withArgs([$gearmanJob])
            ->once()
            ->andReturn(true);
        $workerFactory = \Mockery::mock(WorkerFactory::class);
        $workerFactory->shouldReceive('createWorker')
            ->withArgs([$handler, 'writeToDB', '127.0.0.1', 4730])
            ->once()
            ->andReturn(Worker::class);
        $worker = new Worker($handler, $workerFactory);
        $worker->setPort(4730);
        self::assertSame(4730, $worker->getPort());
    }

    public function testWorkerExecuting()
    {
        $gearmanJob = \Mockery::mock(GearmanJob::class);
        $handler = \Mockery::mock(DBWriteHandler::class);
        $handler->shouldReceive('handle')
            ->withArgs([$gearmanJob])
            ->once()
            ->andReturn(true);
        $gearmanWorker = \Mockery::mock(GearmanWorker::class);
        $gearmanWorker->shouldReceive('work')
            ->withNoArgs()
            ->once()
            ->andReturn(true);
        $workerFactory = \Mockery::mock(WorkerFactory::class);
        $workerFactory->shouldReceive('createWorker')
            ->withArgs([$handler, 'writeToDB', '127.0.0.1', 4730])
            ->once()
            ->andReturn($gearmanWorker);
        $worker = new Worker($handler, $workerFactory);
        $worker->setHost('127.0.0.1');
        $worker->setPort(4730);
        $worker->init();
        $result = $worker->runIteration();
        self::assertSame(true, $result);
    }
}
