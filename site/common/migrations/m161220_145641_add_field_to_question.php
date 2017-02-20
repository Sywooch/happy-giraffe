<?php

class m161220_145641_add_field_to_question extends CDbMigration
{
	public function safeUp()
	{
	    $sql = 'ALTER TABLE `qa__questions` ADD `attachedChild` INT(11) UNSIGNED, ADD INDEX (`attachedChild`)';

	    $this->dbConnection->createCommand($sql)->execute();
	}

	public function safeDown()
	{
	    $this->dropColumn(\site\frontend\modules\som\modules\qa\models\QaQuestion::model()->tableName(), 'attachedChild');
	}
}