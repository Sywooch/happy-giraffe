<?php

class m111220_055619_report_to_innoDb extends CDbMigration
{
	public function up()
	{
        $this->execute('ALTER TABLE  `report` ENGINE = INNODB');
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