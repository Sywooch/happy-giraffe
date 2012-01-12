<?php

class m120112_081236_change_names_likes_column extends CDbMigration
{
    private $_table = 'name';

    public function up()
	{
        $this->alterColumn($this->_table, 'likes','int unsigned default 0 not null');
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