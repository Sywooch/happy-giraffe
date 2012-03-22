<?php

class m120322_084049_geo_tables_rename extends CDbMigration
{
	public function up()
	{
        $this->renameTable('geo_city', 'geo__city');
        $this->renameTable('geo_country', 'geo__country');
        $this->renameTable('geo_region', 'geo__region');
        $this->renameTable('geo_rus_district', 'geo__rus_district');
        $this->renameTable('geo_rus_region', 'geo__rus_region');
        $this->renameTable('geo_rus_settlement', 'geo__rus_settlement');
        $this->renameTable('geo_rus_settlement_type', 'geo__rus_settlement_type');
        $this->renameTable('geo_rus_street', 'geo__rus_street');
    }

	public function down()
	{
		echo "m120322_084049_geo_tables_rename does not support migration down.\n";
		return false;
	}
}