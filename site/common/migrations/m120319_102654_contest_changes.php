<?php

class m120319_102654_contest_changes extends CDbMigration
{
	public function up()
	{
        $this->execute("DROP TABLE `club_contest_winner`, `club_contest_work_comment`, `club_contest_work`;");
        $this->execute("CREATE TABLE `club_contest_work` (
        `id` INT( 10 ) UNSIGNED NULL ,
        `contest_id` INT( 10 ) UNSIGNED NOT NULL ,
        `user_id` INT( 10 ) UNSIGNED NOT NULL ,
        `title` varchar( 100 ) NOT NULL ,
        `created` DATETIME NOT NULL ,
        PRIMARY KEY ( `id` )
        ) ENGINE = InnoDB;");
        $this->execute("ALTER TABLE `club_contest_work`
          ADD CONSTRAINT `fk_club_contest_work_contest` FOREIGN KEY (`contest_id`) REFERENCES `club_contest` (`contest_id`) ON DELETE CASCADE ON UPDATE CASCADE;
        ALTER TABLE `club_contest_work`
          ADD CONSTRAINT `fk_club_contest_work_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;");
        $this->execute("ALTER TABLE `album_photos` CHANGE `album_id` `album_id` INT( 10 ) UNSIGNED NULL DEFAULT NULL ");
        $this->execute("ALTER TABLE `club_contest_work` CHANGE `id` `id` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT ");
        $this->execute("ALTER TABLE `club_contest_work` ADD `rate` INT( 10 ) NOT NULL ");
        $this->execute("ALTER TABLE `club_contest_work` CHANGE `rate` `rate` INT( 10 ) NOT NULL DEFAULT '0'");
	}

	public function down()
	{

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