<?php

class m161017_115030_specs_sort extends CDbMigration
{
	public function up()
	{
		$this->execute("ALTER TABLE `specialists__specializations` ADD `sort` TINYINT(3)  NOT NULL  AFTER `groupId`;");
		$this->execute("UPDATE `specialists__specializations` SET `title` = 'Педиатр', `sort` = '1' WHERE `title` = 'Детский педиатр';");
	}

	public function down()
	{
		echo "m161017_115030_specs_sort does not support migration down.\n";
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