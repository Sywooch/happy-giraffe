<?php

class m140320_134759_cityPos extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `geo__city` ADD `pos` INT(11)  NOT NULL  AFTER `show_region`;");
        $this->execute("UPDATE geo__city c
JOIN geo__region r ON r.id = c.region_id
SET pos = -1
WHERE ((c.name = 'Москва' AND r.name = 'Москва') OR (c.name = 'Санкт-Петербург' AND r.name = 'Санкт-Петербург')) AND c.type = 'г';");
	}

	public function down()
	{
		echo "m140320_134759_cityPos does not support migration down.\n";
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