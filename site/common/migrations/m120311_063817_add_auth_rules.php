<?php

class m120311_063817_add_auth_rules extends CDbMigration
{
    private $_table = 'auth_item';
	public function up()
	{
        $this->insert($this->_table, array(
            'name'=>'report',
            'type'=>'0',
            'description'=>'Рассмотрение жалоб',
        ));
        $this->insert($this->_table, array(
            'name'=>'names',
            'type'=>'0',
            'description'=>'Заполнение имен',
        ));
        $this->insert($this->_table, array(
            'name'=>'horoscope',
            'type'=>'0',
            'description'=>'Астрологический прогноз',
        ));
        $this->insert($this->_table, array(
            'name'=>'shop',
            'type'=>'0',
            'description'=>'Магазин',
        ));
        $this->insert($this->_table, array(
            'name'=>'interests',
            'type'=>'0',
            'description'=>'Интересы',
        ));

        $this->_table = 'auth_item_child';
        $this->insert($this->_table, array(
            'parent'=>'editor',
            'child'=>'report',
        ));
        $this->insert($this->_table, array(
            'parent'=>'editor',
            'child'=>'names',
        ));
        $this->insert($this->_table, array(
            'parent'=>'editor',
            'child'=>'horoscope',
        ));
        $this->insert($this->_table, array(
            'parent'=>'editor',
            'child'=>'shop',
        ));
        $this->insert($this->_table, array(
            'parent'=>'editor',
            'child'=>'interests',
        ));

        $this->insert($this->_table, array(
            'parent'=>'administrator',
            'child'=>'editor',
        ));
        $this->insert($this->_table, array(
            'parent'=>'supermoderator',
            'child'=>'editor',
        ));
    }

	public function down()
	{
		echo "m120311_063817_add_auth_rules does not support migration down.\n";
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