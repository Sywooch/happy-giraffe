<?php

class m120614_062653_alter_comments extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `comments` CHANGE `entity` `entity` ENUM( 'AlbumPhoto', 'BlogContent', 'CommunityContent', 'ContestWork', 'RecipeBookRecipe', 'User', 'Product', 'CookChoose' ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL");
	}

	public function down()
	{
		echo "m120614_062653_alter_comments does not support migration down.\n";
		return false;
	}
}