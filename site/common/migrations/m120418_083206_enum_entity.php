<?php

class m120418_083206_enum_entity extends CDbMigration
{
    private $_table = 'album__photo_attaches';

	public function up()
	{
        $this->alterColumn($this->_table, 'entity', "ENUM( 'Baby', 'Comment', 'ContestWork', 'User', 'UserPartner' )");

        $this->_table = 'comments';
        $this->alterColumn($this->_table, 'entity', "ENUM( 'AlbumPhoto ', 'BlogContent ', 'CommunityContent ', 'ContestWork ', 'RecipeBookRecipe ', 'User' )");

        $this->_table = 'removed';
        $this->alterColumn($this->_table, 'entity', "ENUM( 'Album ', 'AlbumPhoto ', 'BlogContent ', 'Comment ', 'CommunityContent ', 'ContestWork ', 'RecipeBookRecipe ', 'User' )");

        $this->_table = 'reports';
        $this->alterColumn($this->_table, 'entity', "ENUM( 'Album ', 'AlbumPhoto ', 'BlogContent ', 'Comment ', 'CommunityContent ', 'ContestWork ', 'RecipeBookRecipe ', 'User' )");
	}

	public function down()
	{

	}
}