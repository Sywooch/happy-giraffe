<?php

class m120522_092102_create_content_photos extends CDbMigration
{
	public function up()
	{
        $this->execute("CREATE TABLE happy_giraffe.community__user_photos(
          id INT(10) NOT NULL AUTO_INCREMENT,
          content_id INT(10) UNSIGNED NOT NULL,
          photo_id INT(10) UNSIGNED NOT NULL,
          description TEXT NOT NULL,
          PRIMARY KEY (id),
          CONSTRAINT FK_community__user_photos_album__photos_id FOREIGN KEY (photo_id)
            REFERENCES happy_giraffe.album__photos (id) ON DELETE CASCADE ON UPDATE CASCADE,
          CONSTRAINT FK_community__user_photos_community__contents_id FOREIGN KEY (content_id)
            REFERENCES happy_giraffe.community__contents (id) ON DELETE RESTRICT ON UPDATE RESTRICT
        )
        ENGINE = INNODB
        AUTO_INCREMENT = 1
        CHARACTER SET utf8
        COLLATE utf8_general_ci;");
	}

	public function down()
	{
		echo "m120522_092102_create_content_photos does not support migration down.\n";
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