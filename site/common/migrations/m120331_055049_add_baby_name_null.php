<?php

class m120331_055049_add_baby_name_null extends CDbMigration
{
    private $_table = 'user_baby';
    public function up()
    {
        $this->alterColumn($this->_table, 'name', 'varchar(255)');
    }

    public function down()
	{
		echo "m120331_055049_add_baby_name_null does not support migration down.\n";
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