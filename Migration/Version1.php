<?php

namespace Maxim\EasyBundle\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

class Version1 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql("create table post(id integer auto_increment primary key, title varchar(255))");
    }
}