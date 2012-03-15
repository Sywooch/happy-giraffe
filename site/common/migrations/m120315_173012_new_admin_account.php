<?php

class m120315_173012_new_admin_account extends CDbMigration
{
	public function up()
	{
//        $this->update('user', array(
//            'password'=>'e10adc3949ba59abbe56e057f20f883e',
//        ), 'id=10');
//
//        $this->insert('auth_assignment', array(
//            'itemname'=>'administrator',
//            'userid'=>'10'
//        ));
	}

	public function down()
	{
		echo "m120315_173012_new_admin_account does not support migration down.\n";
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