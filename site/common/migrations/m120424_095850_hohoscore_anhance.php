<?php

class m120424_095850_hohoscore_anhance extends CDbMigration
{
    private $_table = 'services__horoscope';

	public function up()
	{
        $this->addColumn($this->_table, 'year', 'SMALLINT UNSIGNED after zodiac');
        $this->addColumn($this->_table, 'month', 'tinyint UNSIGNED after year');
        $this->addColumn($this->_table, 'week', 'tinyint UNSIGNED after month');
        $this->alterColumn($this->_table, 'date', 'date');
	}

	public function down()
	{
		$this->dropColumn($this->_table,'year');
        $this->dropColumn($this->_table,'week');
        $this->dropColumn($this->_table,'month');
	}
}