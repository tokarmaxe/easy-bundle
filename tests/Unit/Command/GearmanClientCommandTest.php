<?php

namespace Maxim\EasyBundle\Tests\Unit\Command;

use Maxim\EasyBundle\Command\GearmanClientCommand;
use Maxim\EasyBundle\Queue\Worker\Client;
use Mockery;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Output\BufferedOutput;

class GearmanClientCommandTest extends TestCase
{
    public function testGearmanClientCommandConfigureMethod()
    {
        $client = Mockery::mock(Client::class);
        $client->shouldReceive('doNormal')
            ->withArgs(['writeToDB', 'anyString'])
            ->once()
            ->andReturn('Done');
        $command = new GearmanClientCommand($client);
        self::assertNull($command->configure());
    }

    public function testGearmanClientCommandExecMethod()
    {
        $client = Mockery::mock(Client::class);
        $client->shouldReceive('setHost')
            ->withArgs(['172.17.0.1'])
            ->once()
            ->andReturn(NULL);
        $client->shouldReceive('setPort')
            ->withArgs([4730])
            ->once()
            ->andReturn(NULL);
        $client->shouldReceive('doNormal')
            ->withArgs(['writeToDB', 'anyString'])
            ->once()
            ->andReturn('Done');
        $client->shouldReceive('exec')
            ->withArgs(['string'])
            ->once()
            ->andReturn('Done');;
        $command = new GearmanClientCommand($client);
        $command->configure();
        $input = Mockery::mock(ArrayInput::class);
        $input->shouldReceive('bind')
            ->withArgs([InputDefinition::class])
            ->once()
            ->andReturn(NULL);
        $input->shouldReceive('getOption')
            ->withArgs(['string'])
            ->once()
            ->andReturn('string');
        $input->shouldReceive('isInteractive')
            ->withNoArgs()
            ->once()
            ->andReturn(false);
        $input->shouldReceive('hasArgument')
            ->withArgs(['command'])
            ->once()
            ->andReturn(true);
        $input->shouldReceive('getArgument')
            ->withArgs(['command'])
            ->once()
            ->andReturn([]);
        $input->shouldReceive('validate')
            ->withNoArgs()
            ->once()
            ->andReturn(true);
        $result = $command->run($input, new BufferedOutput());
        self::assertSame(0, $result);
    }
}
