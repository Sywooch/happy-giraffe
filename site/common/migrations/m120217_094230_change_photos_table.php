<?php

class m120217_094230_change_photos_table extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `album_photos` CHANGE `id` `id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT ");
	}

	public function down()
	{
		echo "m120217_094230_change_photos_table does not support migration down.\n";
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