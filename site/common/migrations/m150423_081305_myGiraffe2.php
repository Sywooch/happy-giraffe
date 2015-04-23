<?php

class m150423_081305_myGiraffe2 extends CDbMigration
{
	public function up()
	{
		$sql = <<<SQL
ALTER TABLE `myGiraffe__feed_items` CHANGE `id` `id` BIGINT(20)  UNSIGNED  NOT NULL  AUTO_INCREMENT;
SQL;
		$this->execute($sql);
	}

	public function down()
	{
		echo "m150423_081305_myGiraffe2 does not support migration down.\n";
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