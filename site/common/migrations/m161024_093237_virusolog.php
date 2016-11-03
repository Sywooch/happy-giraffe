<?php

class m161024_093237_virusolog extends CDbMigration
{
	public function up()
	{
		$this->execute("INSERT INTO `specialists__specializations` (`id`, `title`, `groupId`, `sort`) VALUES (NULL, 'Детский вирусолог', '1', '0');");
	}

	public function down()
	{
		echo "m161024_093237_virusolog does not support migration down.\n";
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