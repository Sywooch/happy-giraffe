<?php

class m120105_141517_drop_offer_id extends CDbMigration
{
    private $_table = 'bag_offer_vote';

	public function up()
	{
        $this->dropIndex('offer_id',$this->_table);
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