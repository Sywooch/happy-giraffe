<?php

class m111212_151029_edpm_is_express_column extends CDbMigration
{
	private $_table = 'shop__delivery_edpm';
	
	public function up()
	{
		$sql = "ALTER TABLE {$this->_table} ADD COLUMN `is_express` TINYINT(1) NOT NULL DEFAULT '0'";
	}

	public function down()
	{
		$this->dropColumn($this->_table, 'is_express');
	}
}