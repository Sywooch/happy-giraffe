<?php

class m120416_125414_delete_old_geo_tables extends CDbMigration
{
    private $_table = 'user';
    
	public function up()
	{
        $this->dropColumn($this->_table,'pic_small');
        $county_fk = 'SELECT `CONSTRAINT_NAME`
              FROM `information_schema`.`REFERENTIAL_CONSTRAINTS`
              WHERE `TABLE_NAME` = "user" AND `REFERENCED_TABLE_NAME` = "geo__country" AND CONSTRAINT_SCHEMA = "happy_giraffe"';
        $county_fk = Yii::app()->db->createCommand($county_fk)->queryScalar();

        $city_fk = 'SELECT `CONSTRAINT_NAME` FROM `information_schema`.`REFERENTIAL_CONSTRAINTS`
              WHERE `TABLE_NAME` = "user" AND `REFERENCED_TABLE_NAME` = "geo__rus_settlement" AND CONSTRAINT_SCHEMA = "happy_giraffe"';
        $city_fk = Yii::app()->db->createCommand($city_fk)->queryScalar();

        $street_fk = 'SELECT `CONSTRAINT_NAME` FROM `information_schema`.`REFERENTIAL_CONSTRAINTS`
              WHERE `TABLE_NAME` = "user" AND `REFERENCED_TABLE_NAME` = "geo__rus_street" AND CONSTRAINT_SCHEMA = "happy_giraffe"';
        $street_fk = Yii::app()->db->createCommand($street_fk)->queryScalar();

        $this->dropForeignKey($county_fk, $this->_table);
        $this->dropForeignKey($city_fk, $this->_table);
        $this->dropForeignKey($street_fk, $this->_table);
        $this->dropColumn($this->_table,'country_id');
        $this->dropColumn($this->_table,'settlement_id');
        $this->dropColumn($this->_table,'street_id');
        $this->dropColumn($this->_table,'house');
        $this->dropColumn($this->_table,'room');

        $this->dropTable('geo__rus_street');

        $settle_fk = 'SELECT `CONSTRAINT_NAME` FROM `information_schema`.`REFERENTIAL_CONSTRAINTS`
              WHERE `TABLE_NAME` = "geo__rus_district" AND `REFERENCED_TABLE_NAME` = "geo__rus_settlement" AND CONSTRAINT_SCHEMA = "happy_giraffe"';
        $settle_fk = Yii::app()->db->createCommand($settle_fk)->queryScalar();
        $this->dropForeignKey($settle_fk, 'geo__rus_district');

        $this->dropTable('geo__rus_settlement');
        $this->dropTable('geo__rus_settlement_type');
        $this->dropTable('geo__rus_district');
        $this->dropTable('geo__rus_region');
	}

	public function down()
	{
		echo "m120416_125414_delete_old_geo_tables does not support migration down.\n";
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