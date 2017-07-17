<?php

class m170714_103756_add_type_and_additional_field_to_atol_check extends CDbMigration
{
	public function up()
	{
		$this->addColumn('atol_check', 'type', 'varchar(255) not null');
		$this->addColumn('atol_check', 'additional', 'text default null');
	}

	public function down()
	{
		$this->dropColumn('atol_check', 'type');
		$this->dropColumn('atol_check', 'additional');
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