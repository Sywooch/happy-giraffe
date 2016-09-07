<?php

class m131004_141709_photo_widget extends CDbMigration
{
	public function up()
	{
        $this->execute("DROP TABLE IF EXISTS `community__content_gallery_widgets`;

CREATE TABLE `community__content_gallery_widgets` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `gallery_id` int(11) unsigned NOT NULL,
  `item_id` int(11) unsigned DEFAULT NULL,
  `club_id` int(11) unsigned NOT NULL,
  `hidden` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Gallery` (`gallery_id`),
  KEY `Item` (`item_id`),
  KEY `Club` (`club_id`),
  CONSTRAINT `Club` FOREIGN KEY (`club_id`) REFERENCES `community__clubs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `Gallery` FOREIGN KEY (`gallery_id`) REFERENCES `community__content_gallery` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `Item` FOREIGN KEY (`item_id`) REFERENCES `community__content_gallery_items` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
        $this->execute("INSERT INTO `auth__items` (`name`, `type`, `description`, `bizrule`, `data`) VALUES ('communityPhotoWidgets', '0', 'Управление фото-виджетами в клубах', NULL, NULL);");
	}

	public function down()
	{
		echo "m131004_141709_photo_widget does not support migration down.\n";
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