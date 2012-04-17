<?php

class m120328_140702_add_region_pos extends CDbMigration
{
    private $_table = 'geo__region';
	public function up()
	{
        $this->addColumn($this->_table, 'position', 'int(1) default 1000');
        $this->update($this->_table, array('position'=>'1'), 'id=27');
        $this->update($this->_table, array('position'=>'2'), 'id=15');
        $this->update($this->_table, array('position'=>'1'), 'id=72');
        $this->update($this->_table, array('position'=>'2'), 'id=76');
        $this->update($this->_table, array('position'=>'1'), 'id=229');
        $this->update($this->_table, array('position'=>'1001'), 'id=231');
        $this->update($this->_table, array('position'=>'2'), 'id=271');
	}

	public function down()
	{
		$this->dropColumn($this->_table,'position');
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