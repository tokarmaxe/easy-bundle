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
$a = $container->get('doctrine.dbal.default_connection');
/**
 * @var EntityManager
 */
$entityManager = $container->get('doctrine.orm.default_entity_manager');

$migration = new MigrateCommand();
$migration->setName(str_replace('migrations:', '', $migration->getName()));
$input = new ArgvInput;
$input->setInteractive(false);
$migration->run($input, new ConsoleOutput());


//verbosit
//$application->
//$application->setAutoExit(false);
//$application->addCommands($migrations);
//try {
//    $application->run();
//} catch (Exception $e) {
//    $a = 1;
//}
//$command = new DropDatabaseDoctrineCommand($container->get('doctrine'));
//$application->add($command);
//$input = new ArrayInput(array(
//    'command' => 'doctrine:database:drop',
//    '--force' => true,
//));
//$command->run($input, new ConsoleOutput());
//$command = new CreateSchemaDoctrineCommand();
//$application->add($command);
//$input = new ArrayInput(array(
//    'command' => 'doctrine:schema:create',
//));
//$command->run($input, new ConsoleOutput());
//$entityManager->rollback();

//$migration = new ASdASD(asdasd);
//$migration->migrate();
//
//new consoleCommand("doctrine:migrations:migrate");
