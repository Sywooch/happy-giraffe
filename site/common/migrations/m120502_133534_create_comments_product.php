<?php

class m120502_133534_create_comments_product extends CDbMigration
{
	public function up()
	{
        $this->execute("CREATE TABLE IF NOT EXISTS `comments_product` (
          `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
          `text` text,
          `updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
          `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
          `author_id` int(11) unsigned NOT NULL,
          `entity` enum('Product') DEFAULT NULL,
          `entity_id` int(11) unsigned NOT NULL,
          `position` mediumint(8) unsigned NOT NULL,
          `removed` tinyint(1) NOT NULL DEFAULT '0',
          PRIMARY KEY (`id`),
          KEY `comment_product_author_fk` (`author_id`),
          KEY `entity_id` (`entity_id`),
          KEY `entity_index` (`entity`,`entity_id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1635 ;


        ALTER table comments_product  ADD CONSTRAINT `comment_product_author_fk` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;");
        $this->execute("ALTER TABLE `comments_product` ADD `rating` TINYINT NOT NULL DEFAULT '0'");
	}

	public function down()
	{
		echo "m120502_133534_create_comments_product does not support migration down.\n";
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