<?php

class m161111_073139_unused_models_remove extends CDbMigration
{
	public function up()
	{
		$this->execute("SET FOREIGN_KEY_CHECKS=0;");
		$this->execute("DROP TABLE visits;");
		$this->execute("DROP TABLE user__purposes;");
		$this->execute("SET FOREIGN_KEY_CHECKS=1;");
	}

	public function down()
	{
		echo "m161111_073139_unused_models_remove does not support migration down.\n";
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