<?php

class m150204_133140_photopostLabels extends CDbMigration
{

    public function up()
    {
        $sql = <<<SQL
ALTER TABLE `som__photopost` 
ADD COLUMN `labels` TEXT NOT NULL AFTER `dtimeCreate`,
ADD COLUMN `forumId` INT(10) NULL DEFAULT NULL AFTER `labels`;
SQL;
        $this->execute($sql);
    }

    public function down()
    {
        echo "m150204_133140_photopostLabels does not support migration down.\n";
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
