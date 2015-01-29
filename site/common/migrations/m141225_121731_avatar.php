<?php

class m141225_121731_avatar extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `users` ADD `avatarId` INT(11)  UNSIGNED  NULL  DEFAULT NULL  AFTER `status`;");
        $this->execute("ALTER TABLE `users` ADD `avatarInfo` TEXT  NOT NULL  AFTER `avatarId`;");
        $this->execute("DROP TABLE IF EXISTS `photo__crops`;");
        $this->execute("CREATE TABLE `photo__crops` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `x` smallint(5) unsigned NOT NULL,
  `y` smallint(5) unsigned NOT NULL,
  `w` smallint(5) unsigned NOT NULL,
  `h` smallint(5) unsigned NOT NULL,
  `photoId` int(11) unsigned NOT NULL,
  `fsName` varchar(100) DEFAULT NULL,
  `created` int(8) unsigned NOT NULL,
  `updated` int(8) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
	}

	public function down()
	{
		echo "m141225_121731_avatar does not support migration down.\n";
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