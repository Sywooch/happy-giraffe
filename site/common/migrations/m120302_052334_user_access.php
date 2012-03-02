<?php

class m120302_052334_user_access extends CDbMigration
{
	public function up()
	{
        $this->execute("INSERT INTO `happy_giraffe`.`club_community` (
`id` ,
`name` ,
`pic`
)
VALUES (
'999999', 'Блоги пользователей', ''
);

ALTER TABLE `club_community_rubric` ADD `user_id` INT( 10 ) UNSIGNED NULL ;

ALTER TABLE `club_community_rubric` ADD INDEX ( `user_id` ) ;

ALTER TABLE `club_community_rubric` ADD FOREIGN KEY ( `user_id` ) REFERENCES `happy_giraffe`.`user` (
`id`
) ON DELETE CASCADE ON UPDATE CASCADE ;

ALTER TABLE `user` ADD `profile_access` ENUM( 'all', 'registered', 'friends' ) NOT NULL DEFAULT 'all',
ADD `guestbook_access` ENUM( 'all', 'registered', 'friends' ) NOT NULL DEFAULT 'all',
ADD `im_access` ENUM( 'all', 'registered', 'friends' ) NOT NULL DEFAULT 'all';");
	}

	public function down()
	{
		echo "m120302_052334_user_access does not support migration down.\n";
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