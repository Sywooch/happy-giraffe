<?php

class m111220_052025_geo_to_innoDb extends CDbMigration
{
    private $_table = 'geo_rus_district';
	public function up()
	{
        $this->execute('ALTER TABLE  `geo_rus_district` ENGINE = INNODB');
        $this->execute('ALTER TABLE  `geo_rus_region` ENGINE = INNODB');
        $this->execute('ALTER TABLE  `geo_rus_settlement` ENGINE = INNODB');
        $this->execute('ALTER TABLE  `geo_rus_settlement_type` ENGINE = INNODB');
        $this->execute('ALTER TABLE  `geo_rus_street` ENGINE = INNODB');

        $this->addForeignKey($this->_table.'_region_fk', $this->_table, 'region_id', 'geo_rus_region', 'id','CASCADE',"CASCADE");
        $this->alterColumn($this->_table, 'settlement_id', 'int(11) unsigned null');
        $this->addForeignKey($this->_table.'_settlement_fk', $this->_table, 'settlement_id', 'geo_rus_settlement', 'id','CASCADE',"CASCADE");

        $this->_table = 'geo_rus_settlement';
        $this->addForeignKey($this->_table.'_district_fk', $this->_table, 'district_id', 'geo_rus_district', 'id','CASCADE',"CASCADE");
        $this->addForeignKey($this->_table.'_region_fk', $this->_table, 'region_id', 'geo_rus_region', 'id','CASCADE',"CASCADE");
        $this->addForeignKey($this->_table.'_type_fk', $this->_table, 'type_id', 'geo_rus_settlement_type', 'id','CASCADE',"CASCADE");

        $this->_table = 'geo_rus_street';
        $this->addForeignKey($this->_table.'_settlement_fk', $this->_table, 'settlement_id', 'geo_rus_settlement', 'id','CASCADE',"CASCADE");
	}

	public function down()
	{

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