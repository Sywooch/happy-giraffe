<?php

class m140417_132218_tester_role extends CDbMigration
{
	public function up()
	{
        $this->execute("INSERT INTO `auth__items` (`name`, `type`, `description`, `bizrule`, `data`) VALUES ('tester', '2', 'Тестировщик', NULL, NULL);");
        $this->execute("
            INSERT INTO `auth__assignments` (`itemname`,`userid`,`bizrule`,`data`)
            SELECT 'tester',`id`,NULL,'N;'
            FROM `users`
            WHERE `group` = 6;
        ");
	}

	public function down()
	{
		echo "m140417_132218_tester_role does not support migration down.\n";
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