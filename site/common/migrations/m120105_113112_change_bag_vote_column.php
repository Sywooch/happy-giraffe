<?php

class m120105_113112_change_bag_vote_column extends CDbMigration
{
    private $_table = 'bag_user_vote';

	public function up()
	{
        $this->truncateTable($this->_table);
        $this->dropForeignKey('bag_user_vote_offer_fk', $this->_table);
        $this->dropColumn($this->_table,'offer_id');
        $this->addColumn($this->_table, 'object_id', 'int UNSIGNED not null');
        $this->addForeignKey($this->_table . '_object_fk', $this->_table, 'object_id', 'bag_offer', 'id', 'CASCADE', "CASCADE");

        $this->renameTable($this->_table, 'bag_offer_vote');
	}

	public function down()
	{
        $this->renameTable('bag_offer_vote', $this->_table);
        $this->truncateTable($this->_table);
        $this->dropForeignKey($this->_table . '_object_fk', $this->_table);
        $this->dropColumn($this->_table,'object_id');
        $this->addColumn($this->_table, 'offer_id', 'int UNSIGNED not null');
        $this->addForeignKey('bag_user_vote_offer_fk', $this->_table, 'offer_id', 'bag_offer', 'id', 'CASCADE', "CASCADE");
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