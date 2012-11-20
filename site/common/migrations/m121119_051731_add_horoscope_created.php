<?php

class m121119_051731_add_horoscope_created extends CDbMigration
{
    private $_table = 'services__horoscope';

	public function up()
	{
        $this->addColumn($this->_table, 'created', 'timestamp');
	}

	public function down()
	{
		$this->dropColumn($this->_table,'created');
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