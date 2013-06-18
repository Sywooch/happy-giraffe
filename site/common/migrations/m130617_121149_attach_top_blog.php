<?php

class m130617_121149_attach_top_blog extends CDbMigration
{
    private $_table = 'community__contents';
	public function up()
	{
        $this->addColumn($this->_table, 'real_time', 'TIMESTAMP NULL DEFAULT NULL');
	}

	public function down()
	{
		$this->dropColumn($this->_table,'real_time');
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