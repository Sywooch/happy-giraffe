<?php

class m130212_050853_fix_horoscope extends CDbMigration
{
    private $_table = 'services__horoscope_links';
	public function up()
	{
        $this->alterColumn($this->_table, 'some_month', 'varchar(10)');
	}

	public function down()
	{
		echo "m130212_050853_fix_horoscope does not support migration down.\n";
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