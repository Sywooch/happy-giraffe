<?php

class m130808_113419_groups_update_2 extends CDbMigration
{
	public function up()
	{
        $this->execute("DROP TABLE `sites__group_sites`;");
	}

	public function down()
	{
		echo "m130808_113419_groups_update_2 does not support migration down.\n";
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