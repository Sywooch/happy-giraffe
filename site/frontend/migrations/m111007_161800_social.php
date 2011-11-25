<?php

class m111007_161800_social extends CDbMigration
{
    public function up()
    {
	$sql = "CREATE TABLE `club_user_social_service` (
`id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`service` VARCHAR( 255 ) NOT NULL ,
`service_id` VARCHAR( 255 ) NOT NULL ,
`user_id` INT( 11 ) UNSIGNED NOT NULL
) ENGINE = MYISAM ;";
	$this->execute($sql);
	$sql = "ALTER TABLE `club_user_social_service` ADD INDEX ( `user_id` ) ;";
	$this->execute($sql);
    }
 
    public function down()
    {
        echo "m111007_161800_social does not support migration down.\n";
        return false;
    }
}