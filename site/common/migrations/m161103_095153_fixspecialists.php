<?php

class m161103_095153_fixspecialists extends CDbMigration
{
    public function up()
    {
        // #HAG-324 фикс тасков для старых врачей
        $sql = <<<SQL
START TRANSACTION;
BEGIN;

UPDATE specialists__profiles SET authorization_status = 2
 WHERE NOT EXISTS(
  SELECT 1 FROM specialists__profile_authorization_tasks
   WHERE specialists__profile_authorization_tasks.user_id = specialists__profiles.id
 );

INSERT INTO specialists__profile_authorization_tasks (group_relation_id, user_id, status, updated, created)

SELECT
  tt.task_id AS group_relation_id, cp1.id AS user_id, 2 AS status, CURRENT_TIMESTAMP() AS updated, CURRENT_TIMESTAMP() AS created
  FROM specialists__profiles cp1
RIGHT JOIN specialists__group_type_relation tt ON tt.group_id = 1
WHERE NOT EXISTS(SELECT 1 FROM specialists__profile_authorization_tasks spat WHERE spat.user_id = cp1.id);

COMMIT;
SQL;

        \Yii::app()->db->createCommand($sql)->execute();
    }

    public function down()
    {
        echo "m161103_095153_fixspecialists does not support migration down.\n";
        return false;
    }

    /*
    // Use safeUp/safeDown to do migration with transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}