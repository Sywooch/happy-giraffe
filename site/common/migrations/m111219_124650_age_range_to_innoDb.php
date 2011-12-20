<?php

class m111219_124650_age_range_to_innoDb extends CDbMigration
{
	public function up()
	{
        $this->execute('ALTER TABLE  `age_range` ENGINE = INNODB');
	}

	public function down()
	{

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