<?php

class m161017_115030_specs_sort extends CDbMigration
{
	public function up()
	{
		$this->execute("ALTER TABLE `specialists__specializations` ADD `sort` TINYINT(3)  NOT NULL  AFTER `groupId`;");
		$this->execute("INSERT INTO `specialists__specializations` (`id`, `title`, `groupId`, `sort`) VALUES (NULL, 'Педиатор', '1', '1');");
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