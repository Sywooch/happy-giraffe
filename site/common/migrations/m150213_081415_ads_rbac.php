<?php

class m150213_081415_ads_rbac extends CDbMigration
{
	public function up()
	{
		$this->execute("INSERT INTO `newauth__items` (`name`, `type`, `description`, `bizrule`, `data`) VALUES ('manageAnnonces', '1', 'Управление анонсами', NULL, NULL);");
		$this->execute("INSERT INTO `newauth__items` (`name`, `type`, `description`, `bizrule`, `data`) VALUES ('toggleAnounces', '0', 'Переключение состояния анонсов (вкл./выкл.)', NULL, NULL);");
		$this->execute("INSERT INTO `newauth__items_childs` (`parent`, `child`) VALUES ('manageAnounces', 'toggleAnounces');");
	}

	public function down()
	{
		echo "m150213_081415_ads_rbac does not support migration down.\n";
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