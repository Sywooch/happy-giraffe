<?php

class m120113_061825_add_christian_to_names extends CDbMigration
{
    private $_table = 'name';

	public function up()
	{
        $this->addColumn($this->_table, 'saints', 'varchar(2048)');
        $this->alterColumn('name_famous', 'description', 'varchar(256)');
	}

	public function down()
	{
		$this->dropColumn($this->_table,'saints');
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