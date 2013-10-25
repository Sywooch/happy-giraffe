<?php

class m130725_113121_fix_photo_attach extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE  `album__photo_attaches` CHANGE  `entity`  `entity`
        ENUM('Baby',  'Comment',  'ContestWork',  'User',  'UserPartner',  'CookDecoration',
         'CookRecipe',  'MessagingMessage',  'CommunityContent' ) CHARACTER SET utf8
         COLLATE utf8_general_ci NULL DEFAULT NULL");
	}

	public function down()
	{
		echo "m130725_113121_fix_photo_attach does not support migration down.\n";
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