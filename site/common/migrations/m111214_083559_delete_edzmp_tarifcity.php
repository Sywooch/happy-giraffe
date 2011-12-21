<?php

class m111214_083559_delete_edzmp_tarifcity extends CDbMigration
{
	public function up()
	{
		$this->execute("DROP TABLE IF EXISTS `shop__delivery_epricecity`");
	}

	public function down()
	{
		
		echo "m111214_083559_delete_edzmp_tarifcity does not support migration down.\n";
		return false;
	}
}