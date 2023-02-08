<?php

use Doctrine\Migrations\Tools\Console\Command\MigrateCommand;
use Doctrine\ORM\EntityManager;
use Maxim\EasyBundle\Tests\TestKernel;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\Process\Process;

require dirname(__DIR__) . '/vendor/autoload.php';

if (file_exists(dirname(__DIR__).'/config/bootstrap.php')) {
    require dirname(__DIR__).'/config/bootstrap.php';
} elseif (method_exists(Dotenv::class, 'bootEnv')) {
    (new Dotenv())->bootEnv(dirname(__DIR__).'/.env');
}

$kernel = new TestKernel('dev', true);
$kernel->boot();
$container = $kernel->getContainer();
/**
 * @var EntityManager
 */
$entityManager = $container->get('doctrine.orm.default_entity_manager');

$process = new Process(['php','bin/console', 'doctrine:migrations:migrate', '--no-interaction']);
$process->run();
