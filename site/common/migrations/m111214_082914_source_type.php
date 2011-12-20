<?php

class m111214_082914_source_type extends CDbMigration
{
	public function up()
	{
		$this->execute("ALTER TABLE `club_community_post` CHANGE `source_type` `source_type` ENUM( 'me', 'internet', 'book' ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL ;
UPDATE `club_community_post` SET `source_type` = NULL WHERE `source_type` = '';");
	}

	public function down()
	{
		echo "m111214_082914_source_type does not support migration down.\n";
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