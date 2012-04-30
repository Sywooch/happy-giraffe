<?php

class m120430_092750_shop__product_eav_text_values extends CDbMigration
{
	public function up()
	{
        $this->execute("CREATE TABLE `happy_giraffe`.`shop__product_eav_text_values` (
        `id` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
        `value` TEXT NOT NULL
        ) ENGINE = InnoDB;");
        
	}

	public function down()
	{
		echo "m120430_092750_shop__product_eav_text_values does not support migration down.\n";
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