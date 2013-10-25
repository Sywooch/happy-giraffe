<?php

class m130814_125535_recovery_linking extends CDbMigration
{
    private $_table = 'pages_search_phrases';
	public function up()
	{
        $this->addColumn($this->_table, 'last_yandex_position', 'int(3) not null default 1000');
        $this->addColumn($this->_table, 'yandex_traffic', 'int not null default 0');
        $this->addColumn($this->_table, 'google_traffic', 'int not null default 0');
	}

	public function down()
	{
		echo "m130814_125535_recovery_linking does not support migration down.\n";
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