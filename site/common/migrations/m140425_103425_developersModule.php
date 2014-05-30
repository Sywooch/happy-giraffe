<?php

class m140425_103425_developersModule extends CDbMigration
{
	public function up()
	{
        $this->execute("INSERT INTO `auth__items` (`name`, `type`, `description`, `bizrule`, `data`) VALUES ('developersModule', '0', 'Доступ в панель разработчика', NULL, NULL);");
	}

	public function down()
	{
		echo "m140425_103425_developersModule does not support migration down.\n";
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