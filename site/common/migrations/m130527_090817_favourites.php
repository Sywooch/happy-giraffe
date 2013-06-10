<?php

class m130527_090817_favourites extends CDbMigration
{
	public function up()
	{
        $this->execute("INSERT INTO favourites (model_name, model_id, entity, user_id, created)
SELECT
  'CookRecipe' AS model_name,
  recipe_id AS model_id,
  'cook' AS entity,
  user_id,
  created
FROM cook__cook_book;");
	}

	public function down()
	{
		echo "m130527_090817_favourites does not support migration down.\n";
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