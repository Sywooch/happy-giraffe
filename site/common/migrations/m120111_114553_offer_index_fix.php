<?php

class m120111_114553_offer_index_fix extends CDbMigration
{
    private $_table = 'bag_offer_vote';
    
	public function up()
	{
        $this->execute('SET foreign_key_checks = 0;
        DROP INDEX offer_id ON '.$this->_table.';
        SET foreign_key_checks = 1;');
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