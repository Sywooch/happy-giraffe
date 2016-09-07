<?php

class m130416_061600_fu extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE  `community__content_gallery_items` CHANGE  `description`  `description` VARCHAR( 1000 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");
	}

	public function down()
	{
		echo "m130416_061600_fu does not support migration down.\n";
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