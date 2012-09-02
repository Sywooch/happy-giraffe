<?php

class m120831_063328_add_commentator_manager extends CDbMigration
{
    private $_table = 'auth__items';

    public function up()
    {
        $this->insert($this->_table, array(
            'name' => 'commentator-manager',
            'type' => 2,
            'description' => 'Шеф-редактор комментаторов',
        ));
        $this->insert($this->_table, array(
            'name' => 'commentator-manager-panel',
            'type' => 0,
            'description' => 'Панель работы комментатора',
        ));

        $this->insert('auth__items_childs', array(
            'parent' => 'commentator-manager',
            'child' => 'commentator-manager-panel',
        ));

        $this->_table = 'commentators';
        $this->createTable($this->_table, array(
            'manager_id' => 'int(10) UNSIGNED NOT NULL',
            'commentator_id' => 'int(10) UNSIGNED NOT NULL',
            'PRIMARY KEY (`commentator_id`)'
        ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');
        $this->addForeignKey('fk_'.$this->_table.'_manager', $this->_table, 'manager_id', 'users', 'id','CASCADE',"CASCADE");
    }

    public function down()
    {
        echo "m120831_063328_add_commentator_manager does not support migration down.\n";
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