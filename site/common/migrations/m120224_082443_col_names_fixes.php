<?php

class m120224_082443_col_names_fixes extends CDbMigration
{
    private $_table = '';
	public function up()
	{
        $this->_table = 'comment';
        $this->alterColumn($this->_table, 'created', 'TIMESTAMP NULL');
        $this->addColumn($this->_table, 'updated', 'TIMESTAMP NULL on update CURRENT_TIMESTAMP DEFAULT null AFTER `text`');
        $this->alterColumn($this->_table, 'created', 'TIMESTAMP NOT NULL');

        $this->_table = 'message_log';
        $this->alterColumn($this->_table, 'created', 'TIMESTAMP NULL');
        $this->addColumn($this->_table, 'updated', 'TIMESTAMP NULL on update CURRENT_TIMESTAMP DEFAULT null AFTER `text`');
        $this->alterColumn($this->_table, 'created', 'TIMESTAMP NOT NULL');

        $this->_table = 'club_community_content';
        $this->alterColumn($this->_table, 'created', 'TIMESTAMP NULL');
        $this->addColumn($this->_table, 'updated', 'TIMESTAMP NULL on update CURRENT_TIMESTAMP DEFAULT null AFTER `name`');
        $this->alterColumn($this->_table, 'created', 'TIMESTAMP NOT NULL');
	}

	public function down()
	{
        $this->_table = 'comment';
        $this->dropColumn($this->_table,'updated');
        $this->_table = 'message_log';
        $this->dropColumn($this->_table,'updated');
        $this->_table = 'club_community_content';
        $this->dropColumn($this->_table,'updated');
	}
}