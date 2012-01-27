<?php

class m120126_082531_activate_qiwi_payment extends CDbMigration
{
	public function up()
	{
        $this->execute("UPDATE `happy_giraffe`.`billing_system` SET `system_status` = '1' WHERE `billing_system`.`system_id` =5;");
	}

	public function down()
	{
        $this->execute("UPDATE `happy_giraffe`.`billing_system` SET `system_status` = '0' WHERE `billing_system`.`system_id` =5;");
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