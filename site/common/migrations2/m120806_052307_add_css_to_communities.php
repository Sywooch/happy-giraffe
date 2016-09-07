<?php

class m120806_052307_add_css_to_communities extends CDbMigration
{
    private $_table = 'community__communities';
	public function up()
	{
        $this->addColumn($this->_table, 'css_class', 'varchar(50)');
        $this->update($this->_table, array('css_class'=>'kids'), 'id <= 18');
        $this->update($this->_table, array('css_class'=>'manwoman'), 'id >= 31 AND id <=32');
        $this->update($this->_table, array('css_class'=>'beauty'), 'id = 29 OR id = 30 OR id = 33');
        $this->update($this->_table, array('css_class'=>'home'), 'id = 22 OR id = 23 OR id = 26 OR id = 28 OR id = 34');
        $this->update($this->_table, array('css_class'=>'hobbies'), 'id = 24 OR id = 25 OR id = 27 OR id = 35');
        $this->update($this->_table, array('css_class'=>'hobbies'), 'id >= 19 AND id <=21');
	}

	public function down()
	{
		$this->dropColumn($this->_table,'css_class');
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