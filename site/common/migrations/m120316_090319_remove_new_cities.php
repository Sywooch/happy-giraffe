<?php

class m120316_090319_remove_new_cities extends CDbMigration
{
	public function up()
	{
        $this->execute('delete from geo_rus_settlement where id > 148321');
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