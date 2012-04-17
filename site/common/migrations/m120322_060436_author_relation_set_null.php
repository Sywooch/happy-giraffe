<?php

class m120322_060436_author_relation_set_null extends CDbMigration
{
	public function up()
	{
        $this->execute("
        ALTER TABLE  `club_community_content` DROP FOREIGN KEY  `club_community_content_author_fk`;
        ALTER TABLE  `club_community_content` ADD FOREIGN KEY (  `author_id` ) REFERENCES  `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
");
	}

	public function down()
	{
		echo "m120322_060436_author_relation_set_null does not support migration down.\n";
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