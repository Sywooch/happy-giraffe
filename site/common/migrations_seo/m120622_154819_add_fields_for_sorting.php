<?php

class m120622_154819_add_fields_for_sorting extends CDbMigration
{
    private $_table = 'pages';

    public function up()
	{
        $this->addColumn($this->_table, 'yandex_pos', 'int not null default 1000');
        $this->addColumn($this->_table, 'google_pos', 'int not null default 1000');
        $this->addColumn($this->_table, 'yandex_week_visits', 'int not null default 0');
        $this->addColumn($this->_table, 'yandex_month_visits', 'int not null default 0');
        $this->addColumn($this->_table, 'google_week_visits', 'int not null default 0');
        $this->addColumn($this->_table, 'google_month_visits', 'int not null default 0');
	}

	public function down()
	{
		$this->dropColumn($this->_table,'yandex_pos');
		$this->dropColumn($this->_table,'google_pos');
		$this->dropColumn($this->_table,'yandex_week_visits');
		$this->dropColumn($this->_table,'yandex_month_visits');
		$this->dropColumn($this->_table,'google_week_visits');
		$this->dropColumn($this->_table,'google_month_visits');
	}
}