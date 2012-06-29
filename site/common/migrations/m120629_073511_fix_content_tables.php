<?php

class m120629_073511_fix_content_tables extends CDbMigration
{
	public function up()
	{
        $this->execute("drop table community__content_gallery_items;");
        $this->execute("drop table community__content_gallery;");
        $this->execute("CREATE TABLE community__content_gallery(
          id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
          content_id INT(10) UNSIGNED NOT NULL,
          title VARCHAR(255) NOT NULL,
          created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
          PRIMARY KEY (id),
          CONSTRAINT FK_community__content_gallery_community__contents_id FOREIGN KEY (content_id)
          REFERENCES community__contents (id) ON DELETE CASCADE ON UPDATE CASCADE
        )
        ENGINE = INNODB
        CHARACTER SET utf8
        COLLATE utf8_general_ci;");
        $this->execute("CREATE TABLE community__content_gallery_items(
          id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
          gallery_id INT(10) UNSIGNED NOT NULL,
          photo_id INT(10) UNSIGNED NOT NULL,
          description VARCHAR(200) NOT NULL,
          PRIMARY KEY (id),
          CONSTRAINT FK_community__content_gallery_item FOREIGN KEY (gallery_id)
          REFERENCES community__content_gallery (id) ON DELETE CASCADE ON UPDATE CASCADE,
          CONSTRAINT FK_community__content_gallery_items_album__photos_id FOREIGN KEY (photo_id)
          REFERENCES album__photos (id) ON DELETE CASCADE ON UPDATE CASCADE
        )
        ENGINE = INNODB
        AUTO_INCREMENT = 1
        CHARACTER SET utf8
        COLLATE utf8_general_ci
        COMMENT = 'Галерея поста';");
	}

	public function down()
	{
		echo "m120629_073511_fix_content_tables does not support migration down.\n";
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