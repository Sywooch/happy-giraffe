<?php

class m160323_092734_qa_categories extends CDbMigration
{
	public function up()
	{
		$this->execute("ALTER TABLE `qa__categories` ADD `sort` TINYINT(3)  UNSIGNED  NOT NULL  AFTER `title`;");
	}

	public function down()
	{
		echo "m160323_092734_qa_categories does not support migration down.\n";
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