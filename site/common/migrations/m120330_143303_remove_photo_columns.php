<?php

class m120330_143303_remove_photo_columns extends CDbMigration
{
    private $_table = 'user_partner';
	public function up()
	{
        $this->dropColumn($this->_table,'photo');
        $this->_table = 'user_baby';
        $this->dropColumn($this->_table,'photo');
	}

	public function down()
	{
		echo "m120330_143303_remove_photo_columns does not support migration down.\n";
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