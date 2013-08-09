<?php

class m130808_104403_groups_update extends CDbMigration
{
	public function up()
	{
        $this->execute("CREATE TABLE `sites__groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
	}

	public function down()
	{
		echo "m130808_104403_groups_update does not support migration down.\n";
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