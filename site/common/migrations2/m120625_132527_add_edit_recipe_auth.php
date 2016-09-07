<?php

class m120625_132527_add_edit_recipe_auth extends CDbMigration
{
    private $_table = 'auth__items';
	public function up()
	{
        $this->insert($this->_table, array(
            'name'=>'editCookRecipe',
            'type'=>0,
            'description'=>'Редактирование рецептов',
        ));

        $this->insert($this->_table, array(
            'name'=>'removeCookRecipe',
            'type'=>0,
            'description'=>'Удаление рецептов',
        ));

        $this->insert('auth__items_childs', array(
            'parent'=>'isAuthor',
            'child'=>'editCookRecipe',
        ));

        $this->insert('auth__items_childs', array(
            'parent'=>'isAuthor',
            'child'=>'removeCookRecipe',
        ));
	}

	public function down()
	{
		echo "m120625_132527_add_edit_recipe_auth does not support migration down.\n";
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