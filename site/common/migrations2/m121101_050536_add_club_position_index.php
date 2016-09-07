<?php

class m121101_050536_add_club_position_index extends CDbMigration
{
    private $_table = 'community__communities';
	public function up()
	{
        $this->createIndex('position_index', $this->_table, 'position');
	}

	public function down()
	{
		$this->dropIndex('position_index', $this->_table);
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