<?php

class m120416_123510_rename_recipeBook extends CDbMigration
{
	public function up()
	{
        $this->renameTable('recipeBook_disease', 'recipe_book__diseases');
        $this->renameTable('recipeBook_disease_category', 'recipe_book__disease_categories');
        $this->renameTable('recipeBook_ingredient', 'recipe_book__ingredients');
        $this->renameTable('recipeBook_purpose', 'recipe_book__purposes');
        $this->renameTable('recipeBook_recipe', 'recipe_book__recipes');
        $this->renameTable('recipeBook_recipe_vote', 'recipe_book__recipes_votes');
        $this->renameTable('recipeBook_recipe_via_purpose', 'recipe_book__recipes_purposes');
	}

	public function down()
	{
		echo "m120416_123510_rename_recipeBook does not support migration down.\n";
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