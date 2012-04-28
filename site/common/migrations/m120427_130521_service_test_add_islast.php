<?php

class m120427_130521_service_test_add_islast extends CDbMigration
{
    private $_table = 'test__question_answers';

	public function up()
	{
        $this->addColumn($this->_table, 'islast', 'INT(1) UNSIGNED NOT NULL DEFAULT 0 after `text`');
	}

	public function down()
	{
        $this->dropColumn($this->_table,'islast');
	}
}