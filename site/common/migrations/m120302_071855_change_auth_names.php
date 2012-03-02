<?php

class m120302_071855_change_auth_names extends CDbMigration
{
	public function up()
	{
        $this->execute("
        UPDATE  `happy_giraffe`.`auth_item` SET  `name` =  'removeComment' WHERE  `auth_item`.`name` =  'delete comment' LIMIT 1 ;
        UPDATE  `happy_giraffe`.`auth_item` SET  `name` =  'editComment' WHERE  `auth_item`.`name` =  'edit comment' LIMIT 1 ;
        UPDATE  `happy_giraffe`.`auth_item` SET  `name` =  'removeAlbumPhoto',
        `description` =  'удаление фото' WHERE  `auth_item`.`name` =  'delete photo' LIMIT 1 ;
        UPDATE  `happy_giraffe`.`auth_item` SET  `name` =  'removeCommunityContent' WHERE  `auth_item`.`name` =  'delete post' LIMIT 1 ;
        UPDATE  `happy_giraffe`.`auth_item` SET  `name` =  'editCommunityContent' WHERE  `auth_item`.`name` =  'edit post' LIMIT 1 ;
        UPDATE  `happy_giraffe`.`auth_item` SET  `name` =  'editCommunityRubric' WHERE  `auth_item`.`name` =  'edit rubrics' LIMIT 1 ;
        UPDATE  `happy_giraffe`.`auth_item` SET  `name` =  'editUser' WHERE  `auth_item`.`name` =  'edit user' LIMIT 1 ;
        UPDATE  `happy_giraffe`.`auth_item` SET  `name` =  'editMeta' WHERE  `auth_item`.`name` =  'edit meta' LIMIT 1 ;
        UPDATE  `happy_giraffe`.`auth_item` SET  `name` =  'removeUser' WHERE  `auth_item`.`name` =  'delete user' LIMIT 1 ;
        ");
	}

	public function down()
	{

	}
}