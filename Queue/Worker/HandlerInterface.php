<?php

namespace Maxim\EasyBundle\Queue\Worker;

interface HandlerInterface
{
    public function handle($job);
}