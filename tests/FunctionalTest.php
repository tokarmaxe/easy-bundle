<?php

namespace Maxim\EasyBundle\Tests;

use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManager;
use Maxim\EasyBundle\DataFixtures\PostFixtures;
use Maxim\EasyBundle\Entity\PostEntity;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\Process\Process;

class FunctionalTest extends WebTestCase
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    private KernelBrowser $client;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = $this->createClient(['environment' => 'test'], array(
            'PHP_AUTH_USER' => 'user',
            'PHP_AUTH_PW'   => 'password',
        ));
        $this->client->disableReboot();
        $this->entityManager = $this->client->getContainer()
            ->get('doctrine')
            ->getManager();
        $this->entityManager->beginTransaction();
        $fixture = new PostFixtures();
        $fixture->load($this->entityManager);
    }

    public function testRepository()
    {
        $postRepository = $this->entityManager->getRepository(PostEntity::class);
        $posts = $postRepository->findAll();
        $postCount = count($posts);
        self::assertSame(20, $postCount);
    }

    public function testController()
    {
        $this->client->request('GET', '/get');
        $response = $this->client->getResponse();
        self::assertEquals(200, $response->getStatusCode());
    }

    public function testCommand()
    {
        $processGearmanWorkerCommand = new Process(['php','bin/console', 'gearman-worker-up']);
        $processGearmanWorkerCommand->start();
        $processGearmanClientCommand = new Process(['php','bin/console', 'gearman-client-up', '--string=hello Monica!']);
        $processGearmanClientCommand->run();
        $postRepository = $this->entityManager->getRepository(PostEntity::class);
        $post = $postRepository->find(21);
        self::assertSame('hello Monica!', $post->getTitle());
        $processGearmanWorkerCommand->stop();
        $processGearmanClientCommand->stop();
    }

    protected function tearDown(): void
    {
        $this->entityManager->rollback();

        parent::tearDown();

        $purger = new ORMPurger($this->entityManager);
        $purger->setPurgeMode(ORMPurger::PURGE_MODE_TRUNCATE);
        $purger->purge();

        // doing this is recommended to avoid memory leaks
        $this->entityManager->close();
        $this->entityManager = null;
    }
}