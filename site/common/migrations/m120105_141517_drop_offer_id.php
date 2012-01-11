<?php

class m120105_141517_drop_offer_id extends CDbMigration
{
    private $_table = 'bag_offer_vote';

	public function up()
	{
        $this->truncateTable($this->_table);

        $this->execute('SET foreign_key_checks = 0;');

        $this->dropIndex('offer_id',$this->_table);
        $this->dropColumn($this->_table,'user_id');
        $this->addColumn($this->_table,'user_id', 'int(11) UNSIGNED not null');
        $this->addForeignKey($this->_table.'_user_fk', $this->_table, 'user_id', 'user', 'id','CASCADE',"CASCADE");

        $this->execute('SET foreign_key_checks = 1;');
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