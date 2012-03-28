<?php

class m120327_125603_geo_fixes extends CDbMigration
{
	public function up()
	{
        $this->execute("
        UPDATE `geo__city` SET  `name` =  'Калининград' WHERE  `geo__city`.`id` =342947;
        DELETE FROM geo__region WHERE id = 259;
        UPDATE  `geo__region` SET  `name` =  'Чеченская Республика' WHERE  `geo__region`.`id` =252 LIMIT 1 ;
        UPDATE  `geo__region` SET  `name` =  'Удмуртская Республика' WHERE  `geo__region`.`id` =242 LIMIT 1 ;
        UPDATE  `geo__region` SET  `name` =  'Кабардино-Балкарская Республика' WHERE  `geo__region`.`id` =268 LIMIT 1 ;
        ");
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