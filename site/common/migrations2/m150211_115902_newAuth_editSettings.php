<?php

class m150211_115902_newAuth_editSettings extends CDbMigration
{
	public function up()
	{
		$this->execute("INSERT INTO `newauth__items` (`name`, `type`, `description`, `bizrule`, `data`) VALUES ('editSettings', '0', 'Редактирование настроек', NULL, NULL);");
		$this->execute("INSERT INTO `newauth__items_childs` (`parent`, `child`) VALUES ('manageOwnProfile', 'editSettings');");
	}

	public function down()
	{
		echo "m150211_115902_newAuth_editSettings does not support migration down.\n";
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