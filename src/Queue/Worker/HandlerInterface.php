<?php

namespace Maxim\EasyBundle\Queue\Worker;

use GearmanJob;

interface HandlerInterface
{
    public function handle(GearmanJob $job);
}