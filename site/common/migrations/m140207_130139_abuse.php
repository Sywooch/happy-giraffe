<?php

class m140207_130139_abuse extends CDbMigration
{
	public function up()
	{
        $this->execute("
            CREATE TABLE `antispam__report_abuse_data` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
              `report_id` int(11) unsigned NOT NULL,
              `entity` varchar(255) NOT NULL DEFAULT '',
              `entity_id` int(11) unsigned NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
	}

	public function down()
	{
		echo "m140207_130139_abuse does not support migration down.\n";
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