<?php

class m120514_085110_add_position_to_morning extends CDbMigration
{
    private $_table = 'community__photo_posts';
	public function up()
	{
        $this->addColumn($this->_table, 'position', 'int not null default 0');
	}

	public function down()
	{
		$this->dropColumn($this->_table,'position');
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