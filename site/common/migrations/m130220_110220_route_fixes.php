<?php

class m130220_110220_route_fixes extends CDbMigration
{
	public function up()
	{
        $this->execute("
           update `routes__points` set `city_id` = 8484 where `city_id` = 8302;
update `routes__points` set `city_id` = 425632 where `city_id` = 425463;
update `routes__points` set `city_id` = 437934 where `city_id` = 437062;
update `routes__points` set `city_id` = 435116 where `city_id` = 434622;
UPDATE  `geo__region` SET  `google_name` =  'Крым' WHERE  `geo__region`.`id` =13;
        ");
	}

	public function down()
	{
		echo "m130220_110220_route_fixes does not support migration down.\n";
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