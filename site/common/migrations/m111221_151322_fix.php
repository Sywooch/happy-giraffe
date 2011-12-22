<?php

class m111221_151322_fix extends CDbMigration
{
	public function up()
	{
		$this->dropTable('_delivery_EDPD');
		$this->dropTable('_delivery_EDPM');
		$this->dropTable('_delivery_EDZPM');
		$this->dropTable('_delivery_EExpressDPM');
		$this->dropTable('_delivery_EGruzovozoff');
		$this->dropTable('_delivery_EGruzovozoffTarif');
		$this->dropTable('_delivery_EPickPoint');
		$this->dropTable('_delivery_EPickPointTarif');
		$this->dropTable('_delivery_EPriceCity');
		$this->dropTable('_delivery_ETarif');
		
		$this->dropTable('shop__delivery_EDPD');
		$this->dropTable('shop__delivery_EDPM');
		$this->dropTable('shop__delivery_EDZPM');
		$this->dropTable('shop__delivery_EExpressDPM');
		$this->dropTable('shop__delivery_EGruzovozoff');
		$this->dropTable('shop__delivery_EGruzovozoffTarif');
		$this->dropTable('shop__delivery_EPickPoint');
		$this->dropTable('shop__delivery_EPickPointTarif');
		$this->dropTable('shop__delivery_EPriceCity');
		$this->dropTable('shop__delivery_ETarif');
		$this->dropTable('shop__delivery_ETarifZones');
	}
	
	
	public function dropTable($table) {
		$this->execute("DROP TABLE IF EXISTS `" . $table . '`');
	}

	public function down()
	{
		echo "m111212_115338_delete_unnecessary_tables does not support migration down.\n";
		return false;
	}
}