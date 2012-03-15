<?php

class m120228_081054_rename_user_to_author extends CDbMigration
{
    private $_table = 'recipeBook_recipe';

    public function up()
    {
        $this->dropForeignKey('recipeBook_recipe_user_fk', $this->_table);
        $this->renameColumn($this->_table, 'user_id', 'author_id');
        $this->addForeignKey($this->_table.'_user_fk', $this->_table, 'author_id', 'user', 'id','CASCADE',"CASCADE");
    }

    public function down()
    {
        $this->dropForeignKey('recipeBook_recipe_user_fk', $this->_table);
        $this->renameColumn($this->_table, 'author_id', 'user_id');
        $this->addForeignKey($this->_table.'_user_fk', $this->_table, 'user_id', 'user', 'id','CASCADE',"CASCADE");
    }
}