<?php

class m120628_090511_create_post_photos extends CDbMigration
{
	public function up()
	{
        $this->execute("CREATE TABLE community__content_photo_attaches(
          id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
          content_id INT(10) UNSIGNED NOT NULL,
          photo_id INT(10) UNSIGNED NOT NULL,
          title VARCHAR(70) NOT NULL,
          description VARCHAR(200) NOT NULL,
          created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
          PRIMARY KEY (id),
          CONSTRAINT FK_community__content_photo_attaches_album__photos_id FOREIGN KEY (photo_id)
          REFERENCES album__photos (id) ON DELETE RESTRICT ON UPDATE RESTRICT,
          CONSTRAINT FK_community__content_photo_attaches_community__contents_id FOREIGN KEY (content_id)
          REFERENCES community__contents (id) ON DELETE RESTRICT ON UPDATE RESTRICT
        )
        ENGINE = INNODB
        AUTO_INCREMENT = 1
        CHARACTER SET utf8
        COLLATE utf8_general_ci
        COMMENT = 'Галерея поста';");
	}

	public function down()
	{
		echo "m120628_090511_create_post_photos does not support migration down.\n";
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