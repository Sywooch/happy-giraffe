<?php

class m130626_081559_add_post_privacy extends CDbMigration
{
    private $_table = 'community__contents';

	public function up()
	{
        $this->addColumn($this->_table, 'privacy', 'tinyint not null default 0');
	}

	public function down()
	{
		echo "m130626_081559_add_post_privacy does not support migration down.\n";
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