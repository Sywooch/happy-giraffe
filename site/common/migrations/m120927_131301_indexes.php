<?php

class m120927_131301_indexes extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE  `community__contents` ADD INDEX (  `created` );
ALTER TABLE  `cook__recipes` ADD INDEX (  `created` );
ALTER TABLE  `friends` ADD INDEX (  `created` );
ALTER TABLE  `comments` ADD INDEX (  `created` );");
	}

	public function down()
	{
		echo "m120927_131301_indexes does not support migration down.\n";
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