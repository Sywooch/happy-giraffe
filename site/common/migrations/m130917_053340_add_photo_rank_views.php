<?php

class m130917_053340_add_photo_rank_views extends CDbMigration
{
    private $_table = 'album__photos';
	public function up()
	{
        $this->addColumn($this->_table, 'rate', 'int UNSIGNED NOT NULL default 0');
        $this->addColumn($this->_table, 'views', 'int UNSIGNED NOT NULL default 0');
	}

	public function down()
	{
		echo "m130917_053340_add_photo_rank_views does not support migration down.\n";
		return false;
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