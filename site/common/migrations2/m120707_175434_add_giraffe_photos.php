<?php

class m120707_175434_add_giraffe_photos extends CDbMigration
{
	public function up()
	{
        $this->execute("
INSERT INTO `happy_giraffe`.`album__photos` (`id`, `author_id`, `album_id`, `file_name`, `fs_name`, `title`, `updated`, `created`, `removed`) VALUES (35000, '1', NULL, 'happy_giraffe_comment.jpg', 'happy_giraffe_comment.jpg', 'Веселый Жираф приветствует вас!', CURRENT_TIMESTAMP, NOW(), '0');
INSERT INTO `happy_giraffe`.`album__photos` (`id`, `author_id`, `album_id`, `file_name`, `fs_name`, `title`, `updated`, `created`, `removed`) VALUES (35001, '1', NULL, 'postcard-family-day.jpg', 'postcard-family-day.jpg', 'С днем семьи!', CURRENT_TIMESTAMP, NOW(), '0');
        ");
	}

	public function down()
	{
		echo "m120707_175434_add_giraffe_photos does not support migration down.\n";
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