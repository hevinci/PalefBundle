<?php

namespace HeVinci\PalefBundle\Migrations\pdo_pgsql;

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
                id SERIAL NOT NULL, 
                parent_id INT DEFAULT NULL, 
                root INT DEFAULT NULL, 
                lft INT NOT NULL, 
                lvl INT NOT NULL, 
                rgt INT NOT NULL, 
                description VARCHAR(1024) NOT NULL, 
                PRIMARY KEY(id)
            )
        ");
        $this->addSql("
            CREATE INDEX IDX_61ECD5E6727ACA70 ON hevinci_competency (parent_id)
        ");
        $this->addSql("
            CREATE TABLE hevinci_competency_task (
                competency_id INT NOT NULL, 
                task_id INT NOT NULL, 
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
                id SERIAL NOT NULL, 
                description VARCHAR(1024) NOT NULL, 
                process VARCHAR(128) NOT NULL, 
                complexity INT NOT NULL, 
                knowledge VARCHAR(128) NOT NULL, 
                weight INT NOT NULL, 
                PRIMARY KEY(id)
            )
        ");
        $this->addSql("
            ALTER TABLE hevinci_competency 
            ADD CONSTRAINT FK_61ECD5E6727ACA70 FOREIGN KEY (parent_id) 
            REFERENCES hevinci_competency (id) 
            ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        ");
        $this->addSql("
            ALTER TABLE hevinci_competency_task 
            ADD CONSTRAINT FK_655BA3C8FB9F58C FOREIGN KEY (competency_id) 
            REFERENCES hevinci_competency (id) 
            ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        ");
        $this->addSql("
            ALTER TABLE hevinci_competency_task 
            ADD CONSTRAINT FK_655BA3C88DB60186 FOREIGN KEY (task_id) 
            REFERENCES hevinci_task (id) 
            ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        ");
    }

    public function down(Schema $schema)
    {
        $this->addSql("
            ALTER TABLE hevinci_competency 
            DROP CONSTRAINT FK_61ECD5E6727ACA70
        ");
        $this->addSql("
            ALTER TABLE hevinci_competency_task 
            DROP CONSTRAINT FK_655BA3C8FB9F58C
        ");
        $this->addSql("
            ALTER TABLE hevinci_competency_task 
            DROP CONSTRAINT FK_655BA3C88DB60186
        ");
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