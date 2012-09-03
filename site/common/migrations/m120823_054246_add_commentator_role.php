<?php

class m120823_054246_add_commentator_role extends CDbMigration
{
    private $_table = 'auth__items';

    public function up()
    {
        $this->insert($this->_table, array(
            'name' => 'commentator',
            'type' => 2,
            'description' => 'Комментатор',
        ));
        $this->insert($this->_table, array(
            'name' => 'commentator_panel',
            'type' => 0,
            'description' => 'Панель работы комментатора',
        ));

        $this->insert('auth__items_childs', array(
            'parent'=>'commentator',
            'child'=>'commentator_panel',
        ));
    }

    public function down()
    {
        echo "m120823_054246_add_commentator_role does not support migration down.\n";
        return false;
    }
}