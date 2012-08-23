<?php

class m120813_132032_add_created_proxy extends CDbMigration
{
    private $_table = 'proxies';

	public function up()
	{
        $this->addColumn($this->_table, 'created', 'timestamp null');
        $this->createIndex('value_index', $this->_table, 'value', true);
	}

	public function down()
	{
		$this->dropColumn($this->_table, 'created');
        $this->dropIndex('value_index', $this->_table);
	}
}