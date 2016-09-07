<?php

class m120514_134827_community_contents_rate extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `community__contents` ADD `rate` INT( 10 ) UNSIGNED NOT NULL ");
	}

	public function down()
	{
		echo "m120514_134827_community_contents_rate does not support migration down.\n";
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