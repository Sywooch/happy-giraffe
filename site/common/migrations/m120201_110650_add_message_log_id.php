<?php

class m120201_110650_add_message_log_id extends CDbMigration
{
    private $_table = 'message_log';

	public function up()
	{
        $this->addColumn($this->_table, 'id', 'INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST');
	}

	public function down()
	{
        $this->dropColumn($this->_table,'id');
	}
}