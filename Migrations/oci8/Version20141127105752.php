<?php

namespace HeVinci\PalefBundle\Migrations\oci8;

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
                id NUMBER(10) NOT NULL, 
                exercise_id NUMBER(10) DEFAULT NULL, 
                user_id NUMBER(10) DEFAULT NULL, 
                isCorrect NUMBER(1) NOT NULL, 
                PRIMARY KEY(id)
            )
        ");
        $this->addSql("
            DECLARE constraints_Count NUMBER; BEGIN 
            SELECT COUNT(CONSTRAINT_NAME) INTO constraints_Count 
            FROM USER_CONSTRAINTS 
            WHERE TABLE_NAME = 'HEVINCI_ANSWER' 
            AND CONSTRAINT_TYPE = 'P'; IF constraints_Count = 0 
            OR constraints_Count = '' THEN EXECUTE IMMEDIATE 'ALTER TABLE HEVINCI_ANSWER ADD CONSTRAINT HEVINCI_ANSWER_AI_PK PRIMARY KEY (ID)'; END IF; END;
        ");
        $this->addSql("
            CREATE SEQUENCE HEVINCI_ANSWER_ID_SEQ START WITH 1 MINVALUE 1 INCREMENT BY 1
        ");
        $this->addSql("
            CREATE TRIGGER HEVINCI_ANSWER_AI_PK BEFORE INSERT ON HEVINCI_ANSWER FOR EACH ROW DECLARE last_Sequence NUMBER; last_InsertID NUMBER; BEGIN 
            SELECT HEVINCI_ANSWER_ID_SEQ.NEXTVAL INTO : NEW.ID 
            FROM DUAL; IF (
                : NEW.ID IS NULL 
                OR : NEW.ID = 0
            ) THEN 
            SELECT HEVINCI_ANSWER_ID_SEQ.NEXTVAL INTO : NEW.ID 
            FROM DUAL; ELSE 
            SELECT NVL(Last_Number, 0) INTO last_Sequence 
            FROM User_Sequences 
            WHERE Sequence_Name = 'HEVINCI_ANSWER_ID_SEQ'; 
            SELECT : NEW.ID INTO last_InsertID 
            FROM DUAL; WHILE (last_InsertID > last_Sequence) LOOP 
            SELECT HEVINCI_ANSWER_ID_SEQ.NEXTVAL INTO last_Sequence 
            FROM DUAL; END LOOP; END IF; END;
        ");
        $this->addSql("
            CREATE INDEX IDX_46EB4DD6E934951A ON hevinci_answer (exercise_id)
        ");
        $this->addSql("
            CREATE INDEX IDX_46EB4DD6A76ED395 ON hevinci_answer (user_id)
        ");
        $this->addSql("
            CREATE TABLE hevinci_task_exercise (
                task_id NUMBER(10) NOT NULL, 
                exercise_id NUMBER(10) NOT NULL, 
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
                id NUMBER(10) NOT NULL, 
                description VARCHAR2(1024) NOT NULL, 
                PRIMARY KEY(id)
            )
        ");
        $this->addSql("
            DECLARE constraints_Count NUMBER; BEGIN 
            SELECT COUNT(CONSTRAINT_NAME) INTO constraints_Count 
            FROM USER_CONSTRAINTS 
            WHERE TABLE_NAME = 'HEVINCI_EXERCISE' 
            AND CONSTRAINT_TYPE = 'P'; IF constraints_Count = 0 
            OR constraints_Count = '' THEN EXECUTE IMMEDIATE 'ALTER TABLE HEVINCI_EXERCISE ADD CONSTRAINT HEVINCI_EXERCISE_AI_PK PRIMARY KEY (ID)'; END IF; END;
        ");
        $this->addSql("
            CREATE SEQUENCE HEVINCI_EXERCISE_ID_SEQ START WITH 1 MINVALUE 1 INCREMENT BY 1
        ");
        $this->addSql("
            CREATE TRIGGER HEVINCI_EXERCISE_AI_PK BEFORE INSERT ON HEVINCI_EXERCISE FOR EACH ROW DECLARE last_Sequence NUMBER; last_InsertID NUMBER; BEGIN 
            SELECT HEVINCI_EXERCISE_ID_SEQ.NEXTVAL INTO : NEW.ID 
            FROM DUAL; IF (
                : NEW.ID IS NULL 
                OR : NEW.ID = 0
            ) THEN 
            SELECT HEVINCI_EXERCISE_ID_SEQ.NEXTVAL INTO : NEW.ID 
            FROM DUAL; ELSE 
            SELECT NVL(Last_Number, 0) INTO last_Sequence 
            FROM User_Sequences 
            WHERE Sequence_Name = 'HEVINCI_EXERCISE_ID_SEQ'; 
            SELECT : NEW.ID INTO last_InsertID 
            FROM DUAL; WHILE (last_InsertID > last_Sequence) LOOP 
            SELECT HEVINCI_EXERCISE_ID_SEQ.NEXTVAL INTO last_Sequence 
            FROM DUAL; END LOOP; END IF; END;
        ");
        $this->addSql("
            CREATE TABLE exercise_task (
                exercise_id NUMBER(10) NOT NULL, 
                task_id NUMBER(10) NOT NULL, 
                PRIMARY KEY(exercise_id, task_id)
            )
        ");
        $this->addSql("
            CREATE INDEX IDX_B5BB997E934951A ON exercise_task (exercise_id)
        ");
        $this->addSql("
            CREATE INDEX IDX_B5BB9978DB60186 ON exercise_task (task_id)
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
            DROP CONSTRAINT FK_46EB4DD6E934951A
        ");
        $this->addSql("
            ALTER TABLE hevinci_task_exercise 
            DROP CONSTRAINT FK_7F7E3C96E934951A
        ");
        $this->addSql("
            ALTER TABLE exercise_task 
            DROP CONSTRAINT FK_B5BB997E934951A
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