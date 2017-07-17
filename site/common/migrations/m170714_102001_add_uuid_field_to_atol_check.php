<?php

class m170714_102001_add_uuid_field_to_atol_check extends CDbMigration
{
	public function up()
	{
		$this->addColumn('atol_check', 'uuid', 'varchar(255) not null');
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