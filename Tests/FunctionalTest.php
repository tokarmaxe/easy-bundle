<?php

namespace Maxim\EasyBundle\Tests;

use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManager;
use Maxim\EasyBundle\Command\GearmanCommand;
use Maxim\EasyBundle\Entity\PostEntity;
use Maxim\EasyBundle\Fixtures\PostFixtures;
use Maxim\EasyBundle\Queue\Worker\DBWriteHandler;
use Maxim\EasyBundle\Queue\Worker\Worker;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\ConsoleOutput;
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
//        $fixtureCommand = new LoadDataFixturesDoctrineCommand(
//            new SymfonyFixturesLoader($kernel->getContainer()),
//            $kernel->getContainer()->get('doctrine')
//        );
//        $input = new ArgvInput;
//        $input->setInteractive(false);
//        $fixtureCommand->run($input,new ConsoleOutput());
//        $a = 1;
    }

    public function testRepository()
    {
//        for ($i = 0; $i < 20; $i++) {
//            $post = new PostEntity();
//            $post->setTitle('post #' . $i);
//            $this->entityManager->persist($post);
//        }
//        $this->entityManager->flush();
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
//        $process = new Process(['php', 'Gearman/worker.php', '&']);
//        $process->start();
        $process = new Process(['ls']);
        $process->disableOutput();
        $process->start(function () {
            $worker = new Worker(new DBWriteHandler($this->entityManager));
            $worker->work();
        });
        sleep(1);
        $command = new GearmanCommand();
        $exitCode = $command->run(new ArgvInput(), new ConsoleOutput());
        self::assertSame(0, $exitCode);
        $postRepository = $this->entityManager->getRepository(PostEntity::class);
        $post = $postRepository->find(21);
        self::assertSame('hello Monica!', $post->getTitle());
        $process->stop();
    }

//    public function testWorker()
//    {
//        $worker = new Worker(new DBWriteHandler($this->entityManager));
//        $process = new Process(['php Gearman/worker.php', '&']);
//        $process->start();
//        $process->getPid();
//    }

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