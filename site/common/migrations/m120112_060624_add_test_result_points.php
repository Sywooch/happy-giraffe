<?php

class m120112_060624_add_test_result_points extends CDbMigration
{
    private $_table = 'test_result';

	public function up()
	{
        $this->addColumn($this->_table, 'points', 'tinyint after priority');
	}

	public function down()
	{
        $this->dropColumn($this->_table,'points');
	}
}