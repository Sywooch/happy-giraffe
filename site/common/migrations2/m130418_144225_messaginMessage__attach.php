<?php

class m130418_144225_messaginMessage__attach extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE  `album__photo_attaches` CHANGE  `entity`  `entity` ENUM(  'Baby',  'Comment',  'ContestWork',  'User',  'UserPartner',  'CookDecoration', 'CookRecipe',  'MessagingMessage' ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL");
	}

	public function down()
	{
		echo "m130418_144225_messaginMessage__attach does not support migration down.\n";
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