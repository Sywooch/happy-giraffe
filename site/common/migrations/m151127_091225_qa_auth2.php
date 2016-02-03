<?php

class m151127_091225_qa_auth2 extends CDbMigration
{
	public function up()
	{
		$this->execute("INSERT INTO `newauth__items` (`name`, `type`, `description`, `bizrule`, `data`) VALUES ('createQaAnswer', '0', 'Добавление ответа', NULL, NULL);");
		$this->execute("INSERT INTO `newauth__items` (`name`, `type`, `description`, `bizrule`, `data`) VALUES ('manageQaAnswer', '1', 'Управление ответом', NULL, NULL);");
		$this->execute("INSERT INTO `newauth__items` (`name`, `type`, `description`, `bizrule`, `data`) VALUES ('updateQaAnswer', '0', 'Редактирование ответа', NULL, NULL);");
		$this->execute("INSERT INTO `newauth__items` (`name`, `type`, `description`, `bizrule`, `data`) VALUES ('removeQaAnswer', '0', 'Удаление ответа', NULL, NULL);");
		$this->execute("INSERT INTO `newauth__items` (`name`, `type`, `description`, `bizrule`, `data`) VALUES ('restoreQaAnswer', '0', 'Восстановление ответа', NULL, NULL);");
		$this->execute("INSERT INTO `newauth__items_childs` (`parent`, `child`) VALUES ('user', 'createQaAnswer');");
		$this->execute("INSERT INTO `newauth__items_childs` (`parent`, `child`) VALUES ('manageQaAnswer', 'updateQaAnswer');");
		$this->execute("INSERT INTO `newauth__items_childs` (`parent`, `child`) VALUES ('manageQaAnswer', 'removeQaAnswer');");
		$this->execute("INSERT INTO `newauth__items_childs` (`parent`, `child`) VALUES ('manageQaAnswer', 'restoreQaAnswer');");
		$this->execute("INSERT INTO `newauth__items_childs` (`parent`, `child`) VALUES ('moderator', 'manageQaAnswer');");
		$this->execute("INSERT INTO `newauth__items_childs` (`parent`, `child`) VALUES ('manageOwnContent', 'manageQaAnswer');");
	}

	public function down()
	{
		echo "m151127_091225_qa_auth2 does not support migration down.\n";
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