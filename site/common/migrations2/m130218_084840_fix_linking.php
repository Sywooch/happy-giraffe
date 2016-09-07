<?php

class m130218_084840_fix_linking extends CDbMigration
{
	public function up()
	{
        $this->execute("
        ALTER TABLE  `routes__routes` CHANGE  `out_links_count`  `city_from_out_links_count` TINYINT( 4 ) NOT NULL DEFAULT '0';
        ALTER TABLE  `routes__routes` ADD  `city_to_out_links_count` TINYINT( 4 ) NOT NULL DEFAULT '0';
        ");
	}

	public function down()
	{
		echo "m130218_084840_fix_linking does not support migration down.\n";
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