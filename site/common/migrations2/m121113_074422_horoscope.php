<?php

class m121113_074422_horoscope extends CDbMigration
{
    private $_table = 'services__horoscope';
	public function up()
	{
        $this->addColumn($this->_table, 'health', 'text');
        $this->addColumn($this->_table, 'career', 'text');
        $this->addColumn($this->_table, 'finance', 'text');
        $this->addColumn($this->_table, 'personal', 'text');

        $this->addColumn($this->_table, 'good_days', 'varchar(1024)');
        $this->addColumn($this->_table, 'bad_days', 'varchar(1024)');

        $this->dropColumn($this->_table,'week');
	}

	public function down()
	{
		$this->dropColumn($this->_table,'health');
		$this->dropColumn($this->_table,'career');
		$this->dropColumn($this->_table,'finance');
		$this->dropColumn($this->_table,'personal');
		$this->dropColumn($this->_table,'good_days');
		$this->dropColumn($this->_table,'bad_days');

        $this->addColumn($this->_table, 'week', 'int');
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