<?php

class m130807_114729_disable_correction extends CDbMigration
{
	public function up()
	{
        $this->execute('update `task` set `status` = 6 where `status`=5 OR `status`=4;');
	}

	public function down()
	{
		echo "m130807_114729_disable_correction does not support migration down.\n";
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