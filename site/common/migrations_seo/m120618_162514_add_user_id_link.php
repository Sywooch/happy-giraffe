<?php

class m120618_162514_add_user_id_link extends CDbMigration
{
    private $_table = 'users';
	public function up()
	{
        $this->addColumn($this->_table, 'related_user_id', 'int(11) unsigned null');
	}

	public function down()
	{
		$this->dropColumn($this->_table,'related_user_id');
	}
}