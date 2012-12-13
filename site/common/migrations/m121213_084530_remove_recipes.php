<?php

class m121213_084530_remove_recipes extends CDbMigration
{
    private $_table = 'cook__recipes';

    public function up()
	{
        $this->addColumn($this->_table, 'removed', 'tinyint(1) not null default 0');

        $this->execute("ALTER TABLE  `removed` CHANGE  `entity`  `entity` ENUM(
        'Album',  'AlbumPhoto',  'BlogContent',  'Comment',  'CommunityContent',  'ContestWork',
        'RecipeBookRecipe',  'User',  'CookRecipe' )
        CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT  'Album'");
	}

	public function down()
	{
		echo "m121213_084530_remove_recipes does not support migration down.\n";
		return false;
	}
}