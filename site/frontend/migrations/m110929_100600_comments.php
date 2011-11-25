<?php

class m110929_100600_comments extends CDbMigration
{
    public function up()
    {
	$sql = "ALTER TABLE `club_community_comment` ADD `created` TIMESTAMP NOT NULL ;";
	$this->execute($sql);
    }
 
    public function down()
    {
        echo "m110929_100600_comments does not support migration down.\n";
        return false;
    }
}