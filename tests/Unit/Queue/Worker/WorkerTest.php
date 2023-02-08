<?php

namespace Maxim\EasyBundle\Tests\Unit\Queue\Worker;

use Maxim\EasyBundle\Queue\Worker\DBWriteHandler;
use Maxim\EasyBundle\Queue\Worker\Factory\WorkerFactory;
use Maxim\EasyBundle\Queue\Worker\Worker;
use PHPUnit\Framework\TestCase;

class WorkerTest extends TestCase
{
    public function testWorkerHost()
    {
        $handler = \Mockery::mock(DBWriteHandler::class);
        $handler->shouldReceive('handle')
            ->times(1);
        $workerFactory = \Mockery::mock(WorkerFactory::class);
        $workerFactory->shouldReceive('createWorker')
            ->times(1);
        $worker = new Worker($handler, $workerFactory);
        $worker->setHost('127.0.0.1');
        self::assertSame('127.0.0.1', $worker->getHost());
    }

    public function testWorkerPort()
    {
        $handler = \Mockery::mock(DBWriteHandler::class);
        $handler->shouldReceive('handle')
            ->times(1);
        $workerFactory = \Mockery::mock(WorkerFactory::class);
        $workerFactory->shouldReceive('createWorker')
            ->times(1);
        $worker = new Worker($handler, $workerFactory);
        $worker->setPort(4730);
        self::assertSame(4730, $worker->getPort());
    }

    public function testWorkerExecuting()
    {
        $handler = \Mockery::mock(DBWriteHandler::class);
        $handler->shouldReceive('handle')
            ->times(1);
        $gearmanWorker = \Mockery::mock(\GearmanWorker::class);
        $gearmanWorker->shouldReceive('work')
            ->andReturn(true);
        $workerFactory = \Mockery::mock(WorkerFactory::class);
        $workerFactory->shouldReceive('createWorker')
            ->times(1)
            ->andReturn($gearmanWorker);
        $worker = new Worker($handler, $workerFactory);
        $worker->setHost('127.0.0.1');
        $worker->setPort(4730);
        $worker->init();
        $result = $worker->runIteration();
        self::assertSame(true, $result);
    }
}