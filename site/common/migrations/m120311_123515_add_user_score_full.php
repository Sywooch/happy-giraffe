<?php

class m120311_123515_add_user_score_full extends CDbMigration
{
    private $_table = 'user_scores';

	public function up()
	{
        $this->addColumn($this->_table, 'full', 'tinyint(1) default 0');
	}

	public function down()
	{
		$this->dropColumn($this->_table,'full');
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