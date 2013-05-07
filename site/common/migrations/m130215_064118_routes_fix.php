<?php

class m130215_064118_routes_fix extends CDbMigration
{
	public function up()
	{
        $this->execute("
        ALTER TABLE  `removed` CHANGE  `entity`  `entity` ENUM(  'Album',  'AlbumPhoto',  'BlogContent',  'Comment',  'CommunityContent',  'ContestWork',  'RecipeBookRecipe',  'User',  'CookRecipe',  'Route' ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT  'Album'
        ");
	}

	public function down()
	{
		echo "m130215_064118_routes_fix does not support migration down.\n";
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