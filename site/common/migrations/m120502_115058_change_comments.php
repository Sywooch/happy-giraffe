<?php

class m120502_115058_change_comments extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `comments` CHANGE `entity` `entity` ENUM( 'AlbumPhoto', 'BlogContent', 'CommunityContent', 'ContestWork', 'RecipeBookRecipe', 'User', 'Product' ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ");
	}

	public function down()
	{
		echo "m120502_115058_change_comments does not support migration down.\n";
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