<?php

namespace HeVinci\PalefBundle\Migrations\pdo_oci;

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
                id NUMBER(10) NOT NULL, 
                parent_id NUMBER(10) DEFAULT NULL, 
                root NUMBER(10) DEFAULT NULL, 
                lft NUMBER(10) NOT NULL, 
                lvl NUMBER(10) NOT NULL, 
                rgt NUMBER(10) NOT NULL, 
                description VARCHAR2(1024) NOT NULL, 
                PRIMARY KEY(id)
            )
        ");
        $this->addSql("
            DECLARE constraints_Count NUMBER; BEGIN 
            SELECT COUNT(CONSTRAINT_NAME) INTO constraints_Count 
            FROM USER_CONSTRAINTS 
            WHERE TABLE_NAME = 'HEVINCI_COMPETENCY' 
            AND CONSTRAINT_TYPE = 'P'; IF constraints_Count = 0 
            OR constraints_Count = '' THEN EXECUTE IMMEDIATE 'ALTER TABLE HEVINCI_COMPETENCY ADD CONSTRAINT HEVINCI_COMPETENCY_AI_PK PRIMARY KEY (ID)'; END IF; END;
        ");
        $this->addSql("
            CREATE SEQUENCE HEVINCI_COMPETENCY_ID_SEQ START WITH 1 MINVALUE 1 INCREMENT BY 1
        ");
        $this->addSql("
            CREATE TRIGGER HEVINCI_COMPETENCY_AI_PK BEFORE INSERT ON HEVINCI_COMPETENCY FOR EACH ROW DECLARE last_Sequence NUMBER; last_InsertID NUMBER; BEGIN 
            SELECT HEVINCI_COMPETENCY_ID_SEQ.NEXTVAL INTO : NEW.ID 
            FROM DUAL; IF (
                : NEW.ID IS NULL 
                OR : NEW.ID = 0
            ) THEN 
            SELECT HEVINCI_COMPETENCY_ID_SEQ.NEXTVAL INTO : NEW.ID 
            FROM DUAL; ELSE 
            SELECT NVL(Last_Number, 0) INTO last_Sequence 
            FROM User_Sequences 
            WHERE Sequence_Name = 'HEVINCI_COMPETENCY_ID_SEQ'; 
            SELECT : NEW.ID INTO last_InsertID 
            FROM DUAL; WHILE (last_InsertID > last_Sequence) LOOP 
            SELECT HEVINCI_COMPETENCY_ID_SEQ.NEXTVAL INTO last_Sequence 
            FROM DUAL; END LOOP; END IF; END;
        ");
        $this->addSql("
            CREATE INDEX IDX_61ECD5E6727ACA70 ON hevinci_competency (parent_id)
        ");
        $this->addSql("
            CREATE TABLE hevinci_competency_task (
                competency_id NUMBER(10) NOT NULL, 
                task_id NUMBER(10) NOT NULL, 
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
                id NUMBER(10) NOT NULL, 
                description VARCHAR2(1024) NOT NULL, 
                process VARCHAR2(128) NOT NULL, 
                complexity NUMBER(10) NOT NULL, 
                knowledge VARCHAR2(128) NOT NULL, 
                weight NUMBER(10) NOT NULL, 
                PRIMARY KEY(id)
            )
        ");
        $this->addSql("
            DECLARE constraints_Count NUMBER; BEGIN 
            SELECT COUNT(CONSTRAINT_NAME) INTO constraints_Count 
            FROM USER_CONSTRAINTS 
            WHERE TABLE_NAME = 'HEVINCI_TASK' 
            AND CONSTRAINT_TYPE = 'P'; IF constraints_Count = 0 
            OR constraints_Count = '' THEN EXECUTE IMMEDIATE 'ALTER TABLE HEVINCI_TASK ADD CONSTRAINT HEVINCI_TASK_AI_PK PRIMARY KEY (ID)'; END IF; END;
        ");
        $this->addSql("
            CREATE SEQUENCE HEVINCI_TASK_ID_SEQ START WITH 1 MINVALUE 1 INCREMENT BY 1
        ");
        $this->addSql("
            CREATE TRIGGER HEVINCI_TASK_AI_PK BEFORE INSERT ON HEVINCI_TASK FOR EACH ROW DECLARE last_Sequence NUMBER; last_InsertID NUMBER; BEGIN 
            SELECT HEVINCI_TASK_ID_SEQ.NEXTVAL INTO : NEW.ID 
            FROM DUAL; IF (
                : NEW.ID IS NULL 
                OR : NEW.ID = 0
            ) THEN 
            SELECT HEVINCI_TASK_ID_SEQ.NEXTVAL INTO : NEW.ID 
            FROM DUAL; ELSE 
            SELECT NVL(Last_Number, 0) INTO last_Sequence 
            FROM User_Sequences 
            WHERE Sequence_Name = 'HEVINCI_TASK_ID_SEQ'; 
            SELECT : NEW.ID INTO last_InsertID 
            FROM DUAL; WHILE (last_InsertID > last_Sequence) LOOP 
            SELECT HEVINCI_TASK_ID_SEQ.NEXTVAL INTO last_Sequence 
            FROM DUAL; END LOOP; END IF; END;
        ");
        $this->addSql("
            ALTER TABLE hevinci_competency 
            ADD CONSTRAINT FK_61ECD5E6727ACA70 FOREIGN KEY (parent_id) 
            REFERENCES hevinci_competency (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE hevinci_competency_task 
            ADD CONSTRAINT FK_655BA3C8FB9F58C FOREIGN KEY (competency_id) 
            REFERENCES hevinci_competency (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE hevinci_competency_task 
            ADD CONSTRAINT FK_655BA3C88DB60186 FOREIGN KEY (task_id) 
            REFERENCES hevinci_task (id) 
            ON DELETE CASCADE
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