<?php

class m120304_105803_add_removed_col extends CDbMigration
{
    private $_table = 'club_community_content';
	public function up()
	{
        $this->addColumn($this->_table, 'removed', 'tinyint(1) default 0 not null');
	}

	public function down()
	{
        $this->dropColumn($this->_table,'removed');
	}
}