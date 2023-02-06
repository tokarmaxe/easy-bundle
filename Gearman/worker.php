<?php

use Doctrine\ORM\EntityManager;
use Maxim\EasyBundle\Entity\PostEntity;
use Maxim\EasyBundle\Tests\TestKernel;

require dirname(__DIR__) . '/vendor/autoload.php';

$worker = new GearmanWorker();
$worker->addServer('172.17.0.1', 4730);
$worker->addFunction('writeToDB', 'write');

while($worker->work());

function write($job)
{
    $kernel = new TestKernel('dev', true);
    $kernel->boot();
    $container = $kernel->getContainer();
    /**
     * @var EntityManager
     */
    $entityManager = $container->get('doctrine.orm.default_entity_manager');
    $post = new PostEntity();
    $post->setTitle($job->workload());
    $entityManager->persist($post);
    $entityManager->flush();
}