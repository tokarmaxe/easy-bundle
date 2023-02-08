<?php

namespace Maxim\EasyBundle\Queue\Worker;

use GearmanWorker;
use Maxim\EasyBundle\Queue\Worker\Factory\WorkerFactory;

class Worker
{
    private HandlerInterface $handler;

    private WorkerFactory $workerFactory;

    private GearmanWorker $worker;

    private string $host;

    private int $port;

    private bool $stopped = false;

    public function __construct(DBWriteHandler $handler, WorkerFactory $workerFactory)
    {
        $this->handler = $handler;
        $this->workerFactory = $workerFactory;
    }

    public function work()
    {
        $this->init();
        while ($this->stopped === false) {
            $this->worker->work();
        }
    }

    public function setHost(string $host)
    {
        $this->host = $host;
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function setPort(int $port)
    {
        $this->port = $port;
    }

    public function getPort(): int
    {
        return $this->port;
    }

    public function runIteration(): bool
    {
        return $this->worker->work();
    }

    public function init()
    {
        $this->worker = $this->workerFactory->createWorker(
            $this->handler,
            'writeToDB',
            $this->getHost(), $this->getPort()
        );
    }
}