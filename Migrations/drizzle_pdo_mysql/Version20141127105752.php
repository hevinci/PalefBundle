<?php

namespace HeVinci\PalefBundle\Migrations\drizzle_pdo_mysql;

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
                id INT AUTO_INCREMENT NOT NULL, 
                exercise_id INT DEFAULT NULL, 
                user_id INT DEFAULT NULL, 
                isCorrect BOOLEAN NOT NULL, 
                PRIMARY KEY(id), 
                INDEX IDX_46EB4DD6E934951A (exercise_id), 
                INDEX IDX_46EB4DD6A76ED395 (user_id)
            )
        ");
        $this->addSql("
            CREATE TABLE hevinci_task_exercise (
                task_id INT NOT NULL, 
                exercise_id INT NOT NULL, 
                PRIMARY KEY(task_id, exercise_id), 
                INDEX IDX_7F7E3C968DB60186 (task_id), 
                INDEX IDX_7F7E3C96E934951A (exercise_id)
            )
        ");
        $this->addSql("
            CREATE TABLE hevinci_exercise (
                id INT AUTO_INCREMENT NOT NULL, 
                description VARCHAR(1024) NOT NULL, 
                PRIMARY KEY(id)
            )
        ");
        $this->addSql("
            CREATE TABLE exercise_task (
                exercise_id INT NOT NULL, 
                task_id INT NOT NULL, 
                PRIMARY KEY(exercise_id, task_id), 
                INDEX IDX_B5BB997E934951A (exercise_id), 
                INDEX IDX_B5BB9978DB60186 (task_id)
            )
        ");
        $this->addSql("
            ALTER TABLE hevinci_answer 
            ADD CONSTRAINT FK_46EB4DD6E934951A FOREIGN KEY (exercise_id) 
            REFERENCES hevinci_exercise (id)
        ");
        $this->addSql("
            ALTER TABLE hevinci_answer 
            ADD CONSTRAINT FK_46EB4DD6A76ED395 FOREIGN KEY (user_id) 
            REFERENCES claro_user (id)
        ");
        $this->addSql("
            ALTER TABLE hevinci_task_exercise 
            ADD CONSTRAINT FK_7F7E3C968DB60186 FOREIGN KEY (task_id) 
            REFERENCES hevinci_task (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE hevinci_task_exercise 
            ADD CONSTRAINT FK_7F7E3C96E934951A FOREIGN KEY (exercise_id) 
            REFERENCES hevinci_exercise (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE exercise_task 
            ADD CONSTRAINT FK_B5BB997E934951A FOREIGN KEY (exercise_id) 
            REFERENCES hevinci_exercise (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE exercise_task 
            ADD CONSTRAINT FK_B5BB9978DB60186 FOREIGN KEY (task_id) 
            REFERENCES hevinci_task (id) 
            ON DELETE CASCADE
        ");
    }

    public function down(Schema $schema)
    {
        $this->addSql("
            ALTER TABLE hevinci_answer 
            DROP FOREIGN KEY FK_46EB4DD6E934951A
        ");
        $this->addSql("
            ALTER TABLE hevinci_task_exercise 
            DROP FOREIGN KEY FK_7F7E3C96E934951A
        ");
        $this->addSql("
            ALTER TABLE exercise_task 
            DROP FOREIGN KEY FK_B5BB997E934951A
        ");
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