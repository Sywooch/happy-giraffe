<?php

class m120802_051425_recipeBook extends CDbMigration
{
	public function up()
	{
        $this->execute("INSERT INTO `happy_giraffe`.`auth__items` (
`name` ,
`type` ,
`description` ,
`bizrule` ,
`data`
)
VALUES (
'editRecipeBookRecipe', '0', 'Редактирование народных рецептов', NULL , NULL
);");
	}

	public function down()
	{
		echo "m120802_051425_recipeBook does not support migration down.\n";
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