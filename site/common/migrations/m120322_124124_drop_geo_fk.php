<?php

class m120322_124124_drop_geo_fk extends CDbMigration
{
	public function up()
	{
        $this->execute('SET foreign_key_checks = 0; alter table user DROP FOREIGN KEY user_ibfk_13;');
	}

	public function down()
	{
//		echo "m120322_124124_drop_geo_fk does not support migration down.\n";
//		return false;
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