<?php

class m130408_094614_Photo_gallery_auth extends CDbMigration
{

	public function up()
	{
        $this->execute("
        INSERT INTO `happy_giraffe`.`auth__items` (`name`, `type`, `description`, `bizrule`, `data`) VALUES ('photo_gallery', '0', 'Размещение фотогалерей', NULL, NULL);

        INSERT INTO `happy_giraffe`.`auth__items_childs` (`parent`, `child`) VALUES
        ('editor', 'photo_gallery'),
        ('administrator', 'photo_gallery'),
        ('moderator', 'photo_gallery'),
        ('supermoderator', 'photo_gallery'),
        ('virtual_user', 'photo_gallery');
        ");
	}

	public function down()
	{
		echo "m130408_094614_Photo_gallery_auth does not support migration down.\n";
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