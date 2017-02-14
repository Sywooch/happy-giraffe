<?php

class m170214_133353_type_and_value_fields_to_paid_services extends CDbMigration
{
	public function up()
	{
		$this->addColumn('paid_services', 'type', 'int(11) default 0');
		$this->addColumn('paid_services', 'value', 'int(11) default 0');
	}

	public function down()
	{
		$this->dropColumn('paid_services', 'type');
		$this->dropColumn('paid_services', 'value');
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