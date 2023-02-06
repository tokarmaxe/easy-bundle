<?php

namespace Maxim\EasyBundle\Queue\Worker;

use GearmanWorker;

class Worker
{
    private HandlerInterface $handler;

    public function __construct(DBWriteHandler $handler)
    {
        $this->handler = $handler;
    }

    public function work()
    {
        $worker = new GearmanWorker();
        $worker->addServer('172.17.0.1', 4730);
        $worker->addFunction('writeToDB', [$this->handler, 'handle']);

        while($worker->work());
    }
}