<?php

class m170714_102625_add_error_field_to_atol_check extends CDbMigration
{
	public function up()
	{
		$this->addColumn('atol_check', 'error', 'varchar(255) default null');
	}

	public function down()
	{
		$this->dropColumn('atol_check', 'uuid');
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