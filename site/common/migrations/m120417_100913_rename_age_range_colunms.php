<?php

class m120417_100913_rename_age_range_colunms extends CDbMigration
{
    private $_table = 'age_range';
	public function up()
	{
        $this->renameColumn($this->_table,'range_id', 'id');
        $this->renameColumn($this->_table,'range_title', 'title');
        $this->renameColumn($this->_table,'range_order', 'position');

        $this->renameTable($this->_table,'age_ranges');
	}

	public function down()
	{
		echo "m120417_100913_rename_age_range_colunms does not support migration down.\n";
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