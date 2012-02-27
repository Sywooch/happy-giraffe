<?php

class m120226_114531_change_albums extends CDbMigration
{
	public function up()
	{
        $this->execute('ALTER TABLE `album_photos` DROP `creation_date`');
        $this->execute("ALTER TABLE `albums` ADD `updated` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , ADD `created` TIMESTAMP NOT NULL ");
        $this->execute("ALTER TABLE `album_photos` ADD `updated` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , ADD `created` TIMESTAMP NOT NULL ");
	}

	public function down()
	{
		echo "m120226_114531_change_albums does not support migration down.\n";
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