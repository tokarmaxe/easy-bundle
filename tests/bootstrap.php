<?php

use Doctrine\Migrations\Tools\Console\Command\MigrateCommand;
use Doctrine\ORM\EntityManager;
use Maxim\EasyBundle\Tests\TestKernel;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Dotenv\Dotenv;

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

$migration = new MigrateCommand();
$migration->setName(str_replace('migrations:', '', $migration->getName()));
$input = new ArgvInput;
$input->setInteractive(false);
$migration->run($input, new ConsoleOutput());
