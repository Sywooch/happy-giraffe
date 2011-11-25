<?php

class m110913_161900_community extends CDbMigration
{
    public function up()
    {
	$sql = "CREATE TABLE `club_community` (
`id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`name` VARCHAR( 255 ) NOT NULL ,
`pic` VARCHAR( 255 ) NOT NULL
) ENGINE = MYISAM ;";
	$this->execute($sql);
	
	$sql = "CREATE TABLE `club_community_rubric` (
`id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`name` VARCHAR( 255 ) NOT NULL ,
`community_id` INT( 11 ) UNSIGNED NOT NULL ,
`type_id` INT( 11 ) UNSIGNED NOT NULL ,
INDEX ( `community_id` ),
INDEX ( `type_id` )
) ENGINE = MYISAM ;";
	$this->execute($sql);
	
	$sql = "CREATE TABLE `club_community_content_type` (
`id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`name` VARCHAR( 255 ) NOT NULL
) ENGINE = MYISAM ;";
	$this->execute($sql);
	
	$sql = "CREATE TABLE `club_community_content` (
`id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`name` VARCHAR( 255 ) NOT NULL ,
`created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
`views` INT( 11 ) UNSIGNED NOT NULL ,
`rating` INT( 11 ) UNSIGNED NOT NULL ,
`author_id` INT( 11 ) UNSIGNED NOT NULL ,
`rubric_id` INT( 11 ) UNSIGNED NULL ,
INDEX ( `author_id` ),
INDEX ( `rubric_id` )
) ENGINE = MYISAM ;";
	$this->execute($sql);
	
	$sql = "CREATE TABLE `club_community_comment` (
`id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`text` TEXT NOT NULL ,
`author_id` INT( 11 ) UNSIGNED NOT NULL ,
`content_id` INT( 11 ) UNSIGNED NOT NULL ,
INDEX ( `author_id` ),
INDEX ( `content_id` )
) ENGINE = MYISAM ;";
	$this->execute($sql);
	
	$sql = "CREATE TABLE `club_community_video` (
`id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`link` VARCHAR( 255 ) NOT NULL ,
`text` TEXT NOT NULL ,
`content_id` INT( 11 ) UNSIGNED NOT NULL ,
INDEX ( `content_id` )
) ENGINE = MYISAM ;";
	$this->execute($sql);
	
	$sql = "CREATE TABLE `club_community_article` (
`id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`text` TEXT NOT NULL ,
`source_type` ENUM( 'me', 'internet', 'book' ) NOT NULL ,
`internet_link` VARCHAR( 255 ) NULL ,
`book_author` VARCHAR( 255 ) NULL ,
`book_name` VARCHAR( 255 ) NULL ,
`content_id` INT( 11 ) UNSIGNED NOT NULL ,
INDEX ( `content_id` )
) ENGINE = MYISAM ;";
	$this->execute($sql);
    }
 
    public function down()
    {
        echo "m110913_161900_community does not support migration down.\n";
        return false;
    }
}