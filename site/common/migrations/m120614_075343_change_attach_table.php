<?php

class m120614_075343_change_attach_table extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `album__photo_attaches` CHANGE `entity` `entity` ENUM( 'Baby', 'Comment', 'ContestWork', 'User', 'UserPartner', 'CookDecoration', 'CookRecipe' ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ");
	}

	public function down()
	{
		$this->execute("ALTER TABLE `album__photo_attaches` CHANGE `entity` `entity` ENUM( 'Baby', 'Comment', 'ContestWork', 'User', 'UserPartner', 'CookDecoration' ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ");
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