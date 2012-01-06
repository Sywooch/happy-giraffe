<?php

class m120105_122114_change_vaccine_vote extends CDbMigration
{
    private $_table = 'vaccine_date_vote';

	public function up()
	{

        $this->renameTable('vaccine_user_vote', $this->_table);
        $this->truncateTable($this->_table);
        $this->dropColumn($this->_table,'id');

        $this->dropForeignKey('vaccine_user_vote_vaccine_date_fk', $this->_table);
        $this->dropColumn($this->_table,'vaccine_date_id');
        $this->addColumn($this->_table, 'object_id', 'int not null');
        $this->addForeignKey($this->_table . '_object_fk', $this->_table, 'object_id', 'vaccine_date', 'id', 'CASCADE', "CASCADE");
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