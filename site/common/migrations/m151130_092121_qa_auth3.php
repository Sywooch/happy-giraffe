<?php

class m151130_092121_qa_auth3 extends CDbMigration
{
	public function up()
	{
		$sql = <<<'SQL'
		INSERT INTO `newauth__items` (`name`, `type`, `description`, `bizrule`, `data`)
VALUES
	('voteOthersContent', 1, 'Оценка чужого контента', 'return \\site\\frontend\\components\\AuthManager::checkOwner($params[\"entity\"], \\Yii::app()->user->id) === false;', NULL);
");
SQL;
		$this->execute($sql);
		$this->execute("INSERT INTO `newauth__items` (`name`, `type`, `description`, `bizrule`, `data`) VALUES ('voteAnswer', '0', 'Оценка ответа', NULL, NULL);");
		$this->execute("INSERT INTO `newauth__items_childs` (`parent`, `child`) VALUES ('user', 'voteOthersContent');");
		$this->execute("INSERT INTO `newauth__items_childs` (`parent`, `child`) VALUES ('voteOthersContent', 'voteAnswer');");
	}

	public function down()
	{
		echo "m151130_092121_qa_auth3 does not support migration down.\n";
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