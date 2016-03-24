<?php

class m160324_070136_qa_auth_fix extends CDbMigration
{
	public function up()
	{
		$this->execute("UPDATE `newauth__items` SET `bizrule` = NULL WHERE `name` = 'createQaQuestion';");
		$sql = <<<'SQL'
UPDATE `newauth__items` SET `bizrule` = 'return $params[\"question\"]->canBeAnsweredBy(\\Yii::app()->user->id);' WHERE `name` = 'createQaAnswer';
SQL;
		$this->execute($sql);
	}

	public function down()
	{
		echo "m160324_070136_qa_auth_fix does not support migration down.\n";
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