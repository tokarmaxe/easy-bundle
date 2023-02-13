<?php

namespace Maxim\EasyBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public const ROOT_NAME = 'maxim_easy';

    public function getConfigTreeBuilder(): TreeBuilder
    {
        return new TreeBuilder(self::ROOT_NAME);
    }
}
