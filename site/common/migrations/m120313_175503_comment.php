<?php

class m120313_175503_comment extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `comment` ADD INDEX ( `entity_id` ) ;
ALTER TABLE `comment` ADD INDEX ( `response_id` ) ;
ALTER TABLE `comment` ADD INDEX ( `quote_id` ) ;

ALTER TABLE `comment` CHANGE `response_id` `response_id` INT( 10 ) UNSIGNED NULL ;
ALTER TABLE `comment` CHANGE `quote_id` `quote_id` INT( 10 ) UNSIGNED NULL ;

UPDATE `comment` SET `quote_id` = NULL WHERE `quote_id` = 0;
UPDATE `comment` SET `response_id` = NULL WHERE `response_id` = 0;

ALTER TABLE `comment` ADD FOREIGN KEY ( `response_id` ) REFERENCES `happy_giraffe`.`comment` (
`id`
) ON DELETE CASCADE ON UPDATE CASCADE ;

ALTER TABLE `comment` ADD FOREIGN KEY ( `quote_id` ) REFERENCES `happy_giraffe`.`comment` (
`id`
) ON DELETE CASCADE ON UPDATE CASCADE ;");
	}

	public function down()
	{
		echo "m120313_175503_comment does not support migration down.\n";
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