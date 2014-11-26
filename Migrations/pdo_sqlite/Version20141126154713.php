<?php

namespace HeVinci\PalefBundle\Migrations\pdo_sqlite;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated migration based on mapping information: modify it with caution
 *
 * Generation date: 2014/11/26 03:47:14
 */
class Version20141126154713 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("
            CREATE TABLE hevinci_competency (
                id INTEGER NOT NULL, 
                parent_id INTEGER DEFAULT NULL, 
                root INTEGER DEFAULT NULL, 
                lft INTEGER NOT NULL, 
                lvl INTEGER NOT NULL, 
                rgt INTEGER NOT NULL, 
                description VARCHAR(1024) NOT NULL, 
                PRIMARY KEY(id)
            )
        ");
        $this->addSql("
            CREATE INDEX IDX_61ECD5E6727ACA70 ON hevinci_competency (parent_id)
        ");
        $this->addSql("
            CREATE TABLE hevinci_competency_task (
                competency_id INTEGER NOT NULL, 
                task_id INTEGER NOT NULL, 
                PRIMARY KEY(competency_id, task_id)
            )
        ");
        $this->addSql("
            CREATE INDEX IDX_655BA3C8FB9F58C ON hevinci_competency_task (competency_id)
        ");
        $this->addSql("
            CREATE INDEX IDX_655BA3C88DB60186 ON hevinci_competency_task (task_id)
        ");
        $this->addSql("
            CREATE TABLE hevinci_task (
                id INTEGER NOT NULL, 
                description VARCHAR(1024) NOT NULL, 
                process VARCHAR(128) NOT NULL, 
                complexity INTEGER NOT NULL, 
                knowledge VARCHAR(128) NOT NULL, 
                weight INTEGER NOT NULL, 
                PRIMARY KEY(id)
            )
        ");
    }

    public function down(Schema $schema)
    {
        $this->addSql("
            DROP TABLE hevinci_competency
        ");
        $this->addSql("
            DROP TABLE hevinci_competency_task
        ");
        $this->addSql("
            DROP TABLE hevinci_task
        ");
    }
}