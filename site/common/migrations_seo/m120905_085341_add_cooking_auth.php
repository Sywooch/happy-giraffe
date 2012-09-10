<?php

class m120905_085341_add_cooking_auth extends CDbMigration
{
    private $_table = 'auth__items';

    public function up()
    {
        $this->insert($this->_table, array('name' => 'cook-manager', 'type' => 2, 'description' => 'Шеф-редактор кулинарии'));
        $this->insert($this->_table, array('name' => 'cook-manager-panel', 'type' => 0, 'description' => 'Панель Шеф-редактора кулинарии'));
        $this->insert('auth__items_childs', array('parent' => 'cook-manager', 'child' => 'cook-manager-panel'));

        $this->insert($this->_table, array('name' => 'cook-content-manager', 'type' => 2, 'description' => 'Контент-менеджер кулинарии'));
        $this->insert($this->_table, array('name' => 'cook-content-manager-panel', 'type' => 0, 'description' => 'Панель Контент-менеджера кулинарии'));
        $this->insert('auth__items_childs', array('parent' => 'cook-content-manager', 'child' => 'cook-content-manager-panel'));

        $this->insert($this->_table, array('name' => 'cook-author', 'type' => 2, 'description' => 'Кулинар'));
        $this->insert($this->_table, array('name' => 'cook-author-panel', 'type' => 0, 'description' => 'Панель Кулинара кулинарии'));
        $this->insert('auth__items_childs', array('parent' => 'cook-author', 'child' => 'cook-author-panel'));
    }

    public function down()
    {
        echo "m120905_085341_add_cooking_auth does not support migration down.\n";
        return false;
    }
}