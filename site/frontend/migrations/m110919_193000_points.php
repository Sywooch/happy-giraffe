<?php

class m110919_193000_points extends CDbMigration
{
    public function up()
    {
	$sql = "CREATE TABLE `club_user_points_history` (
`id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`note` TEXT NOT NULL ,
`amount` DECIMAL( 5, 2 ) NOT NULL ,
`user_id` INT( 11 ) UNSIGNED NOT NULL
) ENGINE = MYISAM ;";
	$this->execute($sql);
    }
 
    public function down()
    {
        echo "m110919_193000_points does not support migration down.\n";
        return false;
    }
}