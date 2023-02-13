<?php

namespace Maxim\EasyBundle\Tests\Unit\Command;

use Maxim\EasyBundle\Command\GearmanWorkerUpCommand;
use Maxim\EasyBundle\Queue\Worker\Worker;
use Mockery;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class GearmanWorkerUpCommandTest extends TestCase
{
    public function testGearmanWorkerUpCommandExecuteMethod()
    {
        $worker = Mockery::mock(Worker::class);
        $worker->shouldReceive('setHost')
            ->withArgs(['172.17.0.1']);
        $worker->shouldReceive('setPort')
            ->withArgs([4730]);
        $worker->shouldReceive('init')
            ->withNoArgs()
            ->once()
            ->andReturn(NULL);
        $worker->shouldReceive('runIteration')
            ->withNoArgs()
            ->once()
            ->andReturn(true);
        $command = new GearmanWorkerUpCommand($worker);
        $result = $command->execOnce();
        self::assertTrue($result);
    }
}
