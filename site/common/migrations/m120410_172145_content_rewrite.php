<?php

class m120410_172145_content_rewrite extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `club_community_content` ADD `edited` BOOLEAN NOT NULL DEFAULT '0',
ADD `editor_id` INT( 10 ) UNSIGNED NULL ;

ALTER TABLE `club_community_content` ADD INDEX ( `editor_id` ) ;

ALTER TABLE `club_community_content` ADD FOREIGN KEY ( `editor_id` ) REFERENCES `happy_giraffe`.`user` (
`id`
) ON DELETE SET NULL ON UPDATE SET NULL ;");
	}

	public function down()
	{
		echo "m120410_172145_content_rewrite does not support migration down.\n";
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