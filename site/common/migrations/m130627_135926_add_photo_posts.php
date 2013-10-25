<?php

class m130627_135926_add_photo_posts extends CDbMigration
{
	public function up()
	{
        $this->execute("
UPDATE  `community__content_types` SET  `title` =  'Утро с Жирафом',
`title_plural` =  'Утро с Жирафом',
`title_accusative` =  'Утро с Жирафом',
`slug` =  'morning' WHERE  `community__content_types`.`id` =4;

INSERT INTO  `community__content_types` (`id` ,`title` ,`title_plural` ,`title_accusative` ,`slug`)
VALUES ('3',  'Фото-пост',  'Фото-пост',  'Фото-пост',  'photoPost');
");
	}

	public function down()
	{
		echo "m130627_135926_add_photo_posts does not support migration down.\n";
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