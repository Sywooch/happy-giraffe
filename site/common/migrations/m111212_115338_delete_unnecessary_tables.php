<?php

class m111212_115338_delete_unnecessary_tables extends CDbMigration
{
	public function up()
	{
		$this->dropTable('_delivery_edpd');
		$this->dropTable('_delivery_edpm');
		$this->dropTable('_delivery_edzpm');
		$this->dropTable('_delivery_eexpressdpm');
		$this->dropTable('_delivery_egruzovozoff');
		$this->dropTable('_delivery_egruzovozofftarif');
		$this->dropTable('_delivery_epickpoint');
		$this->dropTable('_delivery_epickpointtarif');
		$this->dropTable('_delivery_epricecity');
		$this->dropTable('_delivery_etarif');
	}

	public function down()
	{
		echo "m111212_115338_delete_unnecessary_tables does not support migration down.\n";
		return false;
	}
}