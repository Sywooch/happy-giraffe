<?php

class m120203_090312_add_age_to_product extends CDbMigration
{
    private $_table = 'shop_product';
	public function up()
	{
        $this->addColumn($this->_table, 'age_from', 'SMALLINT');
        $this->addColumn($this->_table, 'age_to', 'SMALLINT');
	}

	public function down()
	{
		$this->dropColumn($this->_table,'age_from');
        $this->dropColumn($this->_table,'age_to');
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