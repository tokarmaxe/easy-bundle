<?php

namespace Maxim\EasyBundle\Queue\Worker;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use GearmanJob;
use Maxim\EasyBundle\Entity\PostEntity;

class DBWriteHandler implements HandlerInterface
{
    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function handle(GearmanJob $job): bool
    {
        try {
            $post = new PostEntity();
            $post->setTitle($job->workload());
            $this->entityManager->persist($post);
            $this->entityManager->flush();
        } catch (ORMException $exception) {
            return false;
        }
        return true;
    }
}