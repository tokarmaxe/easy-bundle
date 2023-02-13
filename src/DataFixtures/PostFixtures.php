<?php

namespace Maxim\EasyBundle\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Maxim\EasyBundle\Entity\PostEntity;

class PostFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 20; $i++) {
            $post = new PostEntity();
            $post->setTitle('Post #' . $i);
            $manager->persist($post);
        }
        $manager->flush();
    }
}
