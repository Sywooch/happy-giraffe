<?php

class m120702_073619_recipe_up2 extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `comments` CHANGE `entity` `entity` ENUM( 'AlbumPhoto', 'BlogContent', 'CommunityContent', 'ContestWork', 'RecipeBookRecipe', 'User', 'Product', 'CookRecipe' ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ");
	}

	public function down()
	{
		echo "m120702_073619_recipe_up2 does not support migration down.\n";
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