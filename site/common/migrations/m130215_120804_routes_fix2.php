<?php

class m130215_120804_routes_fix2 extends CDbMigration
{
	public function up()
	{
        $this->execute("
        ALTER TABLE  `routes__routes` ADD  `out_links_count` TINYINT NOT NULL DEFAULT  '0'
        ");
	}

	public function down()
	{
		echo "m130215_120804_routes_fix2 does not support migration down.\n";
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