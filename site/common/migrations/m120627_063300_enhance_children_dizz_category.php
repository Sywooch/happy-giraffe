<?php

class m120627_063300_enhance_children_dizz_category extends CDbMigration
{
    private $_table = 'recipe_book__disease_categories';
	public function up()
	{
        $this->addColumn($this->_table, 'title_all', 'varchar(255) null');
        $this->addColumn($this->_table, 'description', 'text null');
        $this->addColumn($this->_table, 'description_center', 'text null');
        $this->addColumn($this->_table, 'description_extra', 'text null');
        $this->addColumn($this->_table, 'photo_id', 'int(11) UNSIGNED null');
        $this->_table = 'recipe_book__diseases';
        $this->addColumn($this->_table, 'photo_id', 'int(11) UNSIGNED null');
	}

	public function down()
	{
        $this->dropColumn($this->_table, 'title_all');
		$this->dropColumn($this->_table,'description');
		$this->dropColumn($this->_table,'description_center');
		$this->dropColumn($this->_table,'description_extra');
		$this->dropColumn($this->_table,'photo_id');

        $this->_table = 'recipe_book__diseases';
        $this->dropColumn($this->_table, 'photo_id');
	}
}