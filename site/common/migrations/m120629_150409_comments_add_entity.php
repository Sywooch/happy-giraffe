<?php

class m120629_150409_comments_add_entity extends CDbMigration
{
    public function up()
    {
        $this->execute("ALTER TABLE `comments` CHANGE `entity` `entity` ENUM( 'AlbumPhoto', 'BlogContent', 'CommunityContent', 'ContestWork', 'RecipeBookRecipe', 'User', 'Product', 'CookChoose', 'CookRecipe' ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ");
    }

    public function down()
    {
        echo "m120629_150409_comments_add_entity does not support migration down.\n";
        return false;
    }
}