<?php

class m130807_112411_fix_editor_role extends CDbMigration
{
    public function up()
    {
        $this->insert('auth__items', array(
            'name' => 'main-editor',
            'type' => 2,
            'description' => 'Главный редактор',
        ));
        $this->delete('auth__items_childs', 'parent="editor"');
        $this->delete('auth__items', 'name="corrector"');
    }

    public function down()
    {
        echo "m130807_112411_fix_editor_role does not support migration down.\n";
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