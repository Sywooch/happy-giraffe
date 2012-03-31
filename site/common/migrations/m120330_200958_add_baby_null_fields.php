<?php

class m120330_200958_add_baby_null_fields extends CDbMigration
{
    private $_table = 'user_baby';
	public function up()
	{
        $this->alterColumn($this->_table, 'age_group', 'tinyint(1)');
        $this->alterColumn($this->_table, 'sex', 'tinyint(1) default 0');
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