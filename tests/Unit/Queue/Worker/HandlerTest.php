<?php

namespace Maxim\EasyBundle\Tests\Unit\Queue\Worker;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Maxim\EasyBundle\Queue\Worker\DBWriteHandler;
use PHPUnit\Framework\TestCase;

class HandlerTest extends TestCase
{
    public function testHandleMethod()
    {
        $entityManager = \Mockery::mock(EntityManager::class);
        $entityManager->shouldReceive('persist', 'flush');
        $gearmanJob = \Mockery::mock(\GearmanJob::class);
        $gearmanJob->shouldReceive('workload')
            ->withNoArgs()
            ->once()
            ->andReturn('String');
        $handler = new DBWriteHandler($entityManager);
        self::assertTrue($handler->handle($gearmanJob));
    }

    public function testExceptionHandleMethod()
    {
        $entityManager = \Mockery::mock(EntityManager::class);
        $entityManager->shouldReceive('persist', 'flush')->andThrowExceptions([new ORMException]);
        $gearmanJob = \Mockery::mock(\GearmanJob::class);
        $gearmanJob->shouldReceive('workload')
            ->withNoArgs()
            ->once()
            ->andReturn('String');
        $handler = new DBWriteHandler($entityManager);
        self::assertFalse($handler->handle($gearmanJob));
    }
}
