<?php

namespace Maxim\EasyBundle\Queue\Worker;

use Doctrine\ORM\EntityManager;
use Maxim\EasyBundle\Entity\PostEntity;

class DBWriteHandler implements HandlerInterface
{
    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function handle($job)
    {
        $post = new PostEntity();
        $post->setTitle($job->workload());
        $this->entityManager->persist($post);
        $this->entityManager->flush();
    }
}