<?php

class m130613_102815_remove_source_type extends CDbMigration
{
    private $_table = 'community__posts';

	public function up()
	{
        $this->dropColumn($this->_table, 'source_type');
        $this->dropColumn($this->_table, 'internet_link');
        $this->dropColumn($this->_table, 'internet_favicon');
        $this->dropColumn($this->_table, 'internet_title');
        $this->dropColumn($this->_table, 'book_author');
        $this->dropColumn($this->_table, 'book_name');
        $this->dropColumn($this->_table, 'genre');
	}

	public function down()
	{
		echo "m130613_102815_remove_source_type does not support migration down.\n";
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