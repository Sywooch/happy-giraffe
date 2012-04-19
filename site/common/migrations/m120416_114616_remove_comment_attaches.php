<?php

class m120416_114616_remove_comment_attaches extends CDbMigration
{
    private $_table = 'comment_attaches';

    public function up()
    {
        $this->dropTable($this->_table);
    }

	public function down()
	{
		echo "m120416_114616_remove_comment_attaches does not support migration down.\n";
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