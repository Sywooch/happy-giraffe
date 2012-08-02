<?php

class m120801_164715_recipeBook_display_value extends CDbMigration
{
	public function up()
	{
        $this->execute("update recipe_book__recipes_ingredients set display_value = round(value);");
	}

	public function down()
	{
		echo "m120801_164715_recipeBook_display_value does not support migration down.\n";
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