<?php

class m120229_114242_add_user_partner extends CDbMigration
{
    private $_table = 'user';

	public function up()
	{
        $this->addColumn($this->_table, 'relationship_status', 'tinyint(2)');
        $this->addColumn($this->_table, 'partner_name', 'varchar(255)');
	}

	public function down()
	{
        $this->dropColumn($this->_table,'relationship_status');
        $this->dropColumn($this->_table,'partner_name');
	}
}