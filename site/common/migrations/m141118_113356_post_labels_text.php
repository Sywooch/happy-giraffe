<?php

class m141118_113356_post_labels_text extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `post__labels` CHANGE COLUMN `text` `text` VARCHAR(200) NOT NULL;");
	}

	public function down()
	{
		echo "m141118_113356_post_labels_text does not support migration down.\n";
		return false;
	}
}