<?php

class m120301_144942_change_alek984_password extends CDbMigration
{
    private $_table = 'user';
	public function up()
	{
        $this->update($this->_table, array(
            'password'=>'e10adc3949ba59abbe56e057f20f883e'
        ),'id=9987');
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