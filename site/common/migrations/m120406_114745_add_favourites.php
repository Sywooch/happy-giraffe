<?php

class m120406_114745_add_favourites extends CDbMigration
{
    private $_table = 'user';

    public function up()
	{
        $this->addColumn($this->_table, 'in_favourites', 'tinyint(1) default 0');
        $this->_table = 'club_community_content';
        $this->addColumn($this->_table, 'in_favourites', 'tinyint(1) default 0');

        $this->_table = 'auth_item';
        $exist = Yii::app()->db->createCommand()
            ->select('count(name)')
            ->from($this->_table)
            ->where(' name = "manageFavourites" ')
            ->queryScalar();

        if ($exist == 0){
            $this->insert($this->_table, array(
                'name' => 'manageFavourites',
                'type' => '0',
                'description' => 'Управление избранными элементами',
            ));

            $this->_table = 'auth_item_child';
            $this->insert($this->_table, array('parent'=>'administrator', 'child'=>'manageFavourites'));
            $this->insert($this->_table, array('parent'=>'supermoderator', 'child'=>'manageFavourites'));
        }
	}

	public function down()
	{
		$this->dropColumn($this->_table,'in_favourites');
        $this->_table = 'club_community_content';
        $this->dropColumn($this->_table,'in_favourites');
	}
}