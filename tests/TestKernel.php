<?php

namespace Maxim\EasyBundle\Tests;

use Doctrine\Bundle\DoctrineBundle\DependencyInjection\DoctrineExtension;
use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Maxim\EasyBundle\DependencyInjection\Configuration;
use Maxim\EasyBundle\DependencyInjection\EasyBundleExtension;
use Maxim\EasyBundle\MaximEasyBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\RouteCollectionBuilder;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;

class TestKernel extends Kernel
{
    use MicroKernelTrait;

    public function registerBundles(): array
    {
        return array(
            new FrameworkBundle(),
            new DoctrineBundle(),
            new MaximEasyBundle(),
            new TwigBundle(),
        );
    }

    protected function configureRoutes(RouteCollectionBuilder $routes)
    {
        $routes->import('../config/routes.yaml');
    }

    protected function configureContainer(ContainerBuilder $c, LoaderInterface $loader)
    {
        $c->registerExtension(new EasyBundleExtension());
        $c->loadFromExtension('framework', [
            'secret' => 'MySecretKey',
            'test' => null,
            'form' => null,
            'templating' => [
                'engines' => ['twig'],
            ],
        ]);
        $c->loadFromExtension('twig', ['strict_variables' => '%kernel.debug%']);
        $c->loadFromExtension('doctrine', [
            'orm' => [
                'auto_mapping' => true,
                'mappings' => [
                    'MaximEasyBundle' => [
                        'dir' => 'Entity',
                        'type' => 'annotation',
                        'prefix' => 'Maxim\EasyBundle\Entity',
                        'alias' => 'Maxim\EasyBundle'
                    ],
                ],
            ],
            'dbal' => [
                'dbname' => 'bundle',
                'host' => '172.17.0.1',
                'port' => 9906,
                'user' => 'max',
                'password' => 'maxpass',
                'driver' => 'pdo_mysql'
            ]
        ]);
        $c->loadFromExtension(Configuration::ROOT_NAME);
    }
}
