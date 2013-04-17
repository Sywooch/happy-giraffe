<?php

class m130321_112940_remove_commentators_themes extends CDbMigration
{
    private $_table = 'commentators';
	public function up()
	{
        $this->dropTable($this->_table);
	}

	public function down()
	{
		echo "m130321_112940_remove_commentators_themes does not support migration down.\n";
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