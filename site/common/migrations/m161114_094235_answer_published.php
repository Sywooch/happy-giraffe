<?php

class m161114_094235_answer_published extends CDbMigration
{
    public function safeUp()
    {
        $sql = 'ALTER TABLE `qa__answers` ADD `isPublished` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1 AFTER `isRemoved`, ADD INDEX (`isPublished`)';

        $this->dbConnection->createCommand($sql)->execute();
    }

    public function safeDown()
    {
        $this->dropColumn(\site\frontend\modules\som\modules\qa\models\QaAnswer::model()->tableName(), 'isPublished');
    }
}