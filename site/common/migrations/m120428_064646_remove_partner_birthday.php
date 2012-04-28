<?php

class m120428_064646_remove_partner_birthday extends CDbMigration
{
    private $_table = 'user__users_partners';

	public function up()
	{
        $this->dropColumn($this->_table,'birthday');
	}

	public function down()
	{
		echo "m120428_064646_remove_partner_birthday does not support migration down.\n";
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