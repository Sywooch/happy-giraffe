<?php

class m120410_093442_chancge_favourite extends CDbMigration
{
    private $_table = 'user';

	public function up()
	{
        $this->dropColumn($this->_table, 'in_favourites');
        $this->_table = 'club_community_content';
        $this->dropColumn($this->_table, 'in_favourites');
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