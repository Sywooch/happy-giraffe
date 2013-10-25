<?php

class m130902_131447_fix_services extends CDbMigration
{
    private $_table = 'services';
	public function up()
	{
        $this->execute('update services set community_id = null');
        $this->addForeignKey('fk_'.$this->_table.'_club', $this->_table, 'community_id', 'community__clubs', 'id','CASCADE',"CASCADE");

        $this->_table = 'services__communities';
        $this->dropForeignKey('fk_' . $this->_table . '_community', $this->_table);
        $this->addForeignKey('fk_'.$this->_table.'_club', $this->_table, 'community_id', 'community__clubs', 'id','CASCADE',"CASCADE");
	}

	public function down()
	{
		echo "m130902_131447_fix_services does not support migration down.\n";
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