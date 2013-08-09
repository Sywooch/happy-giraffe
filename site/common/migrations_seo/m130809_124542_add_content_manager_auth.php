<?php

class m130809_124542_add_content_manager_auth extends CDbMigration
{
    public function up()
    {
        $this->insert('auth__items', array(
            'name' => 'content-manager-panel',
            'type' => 0,
            'description' => 'Панель контент-менеджера',
        ));

        $this->insert('auth__items_childs', array(
            'parent' => 'content-manager',
            'child' => 'content-manager-panel',
        ));
    }

    public function down()
    {
        echo "m130809_124542_add_content_manager_auth does not support migration down.\n";
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