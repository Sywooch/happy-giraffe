<?php

class m121205_130843_comment_entity_fix extends CDbMigration
{
    private $_table = 'comments';
	public function up()
	{
        $this->alterColumn($this->_table, 'entity', "ENUM('AlbumPhoto',  'BlogContent',  'CommunityContent',  'ContestWork',  'RecipeBookRecipe',  'User',  'Product',  'CookChoose',  'CookRecipe',  'Service') default null");
	}

	public function down()
	{
		echo "m121205_130843_comment_entity_fix does not support migration down.\n";
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