<?php

namespace HeVinci\PalefBundle\Migrations\pdo_sqlite;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated migration based on mapping information: modify it with caution
 *
 * Generation date: 2014/11/27 10:57:53
 */
class Version20141127105752 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("
            CREATE TABLE hevinci_answer (
                id INTEGER NOT NULL, 
                exercise_id INTEGER DEFAULT NULL, 
                user_id INTEGER DEFAULT NULL, 
                isCorrect BOOLEAN NOT NULL, 
                PRIMARY KEY(id)
            )
        ");
        $this->addSql("
            CREATE INDEX IDX_46EB4DD6E934951A ON hevinci_answer (exercise_id)
        ");
        $this->addSql("
            CREATE INDEX IDX_46EB4DD6A76ED395 ON hevinci_answer (user_id)
        ");
        $this->addSql("
            CREATE TABLE hevinci_task_exercise (
                task_id INTEGER NOT NULL, 
                exercise_id INTEGER NOT NULL, 
                PRIMARY KEY(task_id, exercise_id)
            )
        ");
        $this->addSql("
            CREATE INDEX IDX_7F7E3C968DB60186 ON hevinci_task_exercise (task_id)
        ");
        $this->addSql("
            CREATE INDEX IDX_7F7E3C96E934951A ON hevinci_task_exercise (exercise_id)
        ");
        $this->addSql("
            CREATE TABLE hevinci_exercise (
                id INTEGER NOT NULL, 
                description VARCHAR(1024) NOT NULL, 
                PRIMARY KEY(id)
            )
        ");
        $this->addSql("
            CREATE TABLE exercise_task (
                exercise_id INTEGER NOT NULL, 
                task_id INTEGER NOT NULL, 
                PRIMARY KEY(exercise_id, task_id)
            )
        ");
        $this->addSql("
            CREATE INDEX IDX_B5BB997E934951A ON exercise_task (exercise_id)
        ");
        $this->addSql("
            CREATE INDEX IDX_B5BB9978DB60186 ON exercise_task (task_id)
        ");
    }

    public function down(Schema $schema)
    {
        $this->addSql("
            DROP TABLE hevinci_answer
        ");
        $this->addSql("
            DROP TABLE hevinci_task_exercise
        ");
        $this->addSql("
            DROP TABLE hevinci_exercise
        ");
        $this->addSql("
            DROP TABLE exercise_task
        ");
    }
}