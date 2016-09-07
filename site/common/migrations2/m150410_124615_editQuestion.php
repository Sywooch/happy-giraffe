<?php

class m150410_124615_editQuestion extends CDbMigration
{
	public function up()
	{
		$sql = <<<SQL
INSERT INTO `newauth__items` (`name`, `type`, `description`, `bizrule`, `data`) VALUES ('manageConsultationQuestions', '0', 'Управление вопросов в консультации', NULL, NULL);
INSERT INTO `newauth__items_childs` (`parent`, `child`) VALUES ('manageOwnContent', 'manageConsultationQuestions');
INSERT INTO `newauth__items_childs` (`parent`, `child`) VALUES ('moderator', 'manageConsultationQuestions');
SQL;

		$this->execute($sql);
	}

	public function down()
	{
		echo "m150410_124615_editQuestion does not support migration down.\n";
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