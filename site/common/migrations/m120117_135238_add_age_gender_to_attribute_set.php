<?php

class m120117_135238_add_age_gender_to_attribute_set extends CDbMigration
{
    private $_table = 'shop_product_attribute_set';

	public function up()
	{
        $this->addColumn($this->_table, 'age_filter', 'tinyint(1) default 0');
        $this->addColumn($this->_table, 'sex_filter', 'tinyint(1) default 0');
	}

	public function down()
	{
		$this->dropColumn($this->_table,'age_filter');
        $this->dropColumn($this->_table,'sex_filter');
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