<?php

class m120216_124651_create_photos_attaches extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `album_photos` CHANGE `id` `id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT ");
        $this->execute("CREATE TABLE IF NOT EXISTS `album_photos_attaches` (
          `photo_id` int(11) unsigned NOT NULL,
          `entity` varchar(50) NOT NULL,
          `entity_id` int(10) unsigned NOT NULL,
          PRIMARY KEY (`photo_id`,`entity`,`entity_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;;
        ALTER TABLE `album_photos_attaches`
          ADD CONSTRAINT `fk_photo_attach_photo` FOREIGN KEY (`photo_id`) REFERENCES `album_photos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;");
	}

	public function down()
	{
		$this->dropTable('album_photos_attaches');
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