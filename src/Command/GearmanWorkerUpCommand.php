<?php

namespace Maxim\EasyBundle\Command;

use Maxim\EasyBundle\Queue\Worker\Worker;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GearmanWorkerUpCommand extends Command
{
    protected static $defaultName = 'gearman-worker-up';

    private Worker $worker;

    public function __construct(Worker $worker)
    {
        parent::__construct();
        $this->worker = $worker;
    }

    /**
     * @codeCoverageIgnore
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->worker->setHost('172.17.0.1');
        $this->worker->setPort(4730);
        $this->worker->work();
    }

    public function execOnce(): bool
    {
        $this->worker->setHost('172.17.0.1');
        $this->worker->setPort(4730);
        $this->worker->init();
        $this->worker->runIteration();

        return true;
    }
}
