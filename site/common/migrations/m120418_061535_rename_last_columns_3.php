<?php

class m120418_061535_rename_last_columns_3 extends CDbMigration
{
    private $_table = 'bag__offers_votes';

    public function up()
	{
        $this->renameColumn('recipe_book__diseases', 'name', 'title');
        $this->renameColumn('recipe_book__disease_categories', 'name', 'title');
        $this->renameColumn('recipe_book__ingredients', 'name', 'title');
        $this->renameColumn('recipe_book__purposes', 'name', 'title');
        $this->renameColumn('recipe_book__recipes', 'name', 'title');


        $this->dropForeignKey('recipeBook_recipe_vote_recipe_fk', 'recipe_book__recipes_votes');
        $this->renameColumn('recipe_book__recipes_votes', 'object_id', 'entity_id');
        $this->addForeignKey('recipeBook_recipe_vote_recipe_fk', 'recipe_book__recipes_votes', 'entity_id', 'recipe_book__recipes', 'id','CASCADE',"CASCADE");

        $this->dropForeignKey('bag_user_vote_object_fk', 'bag__offers_votes');
        $this->renameColumn('bag__offers_votes', 'object_id', 'entity_id');
        $this->addForeignKey('fk_'.$this->_table.'_entity', 'bag__offers_votes', 'entity_id', 'bag__offers', 'id','CASCADE',"CASCADE");
	}

	public function down()
	{
		echo "m120418_061535_rename_last_columns_3 does not support migration down.\n";
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