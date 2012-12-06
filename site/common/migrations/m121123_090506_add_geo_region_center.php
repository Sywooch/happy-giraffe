<?php

class m121123_090506_add_geo_region_center extends CDbMigration
{
    private $_table = 'geo__region';

	public function up()
	{
        //$this->addForeignKey('fk_'.$this->_table.'_center', $this->_table, 'center_id', 'geo__city', 'id','CASCADE',"CASCADE");
//        $this->execute("INSERT INTO  `happy_giraffe`.`auth__items`
// (`name` ,`type` ,`description` ,`bizrule` ,`data`)
// VALUES ('geo',  '0',  'Редактирование географии', NULL , NULL);");

    }

	public function down()
	{
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