<?php

class m121109_063940_ext_links extends CDbMigration
{
    private $_table = 'externallinks__sites';

	public function up()
	{
        $this->addColumn($this->_table, 'bad_rating', 'tinyint not null default 0');
        $this->addColumn($this->_table, 'comments_count', 'int not null default 3');

        $this->_table = 'externallinks__links';
        $this->alterColumn($this->_table, 'check_link_time', 'datetime null');
	}

	public function down()
	{
		echo "m121109_063940_ext_links does not support migration down.\n";
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