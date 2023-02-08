<?php

namespace Maxim\EasyBundle\Queue\Worker\Factory;

use GearmanWorker;

class WorkerFactory
{
    public function createWorker($handler, $method, $host, $post): GearmanWorker
    {
        $worker = new GearmanWorker();
        $worker->addServer($host, $post);
        $worker->addFunction($method, [$handler, 'handle']);
        return $worker;
    }
}