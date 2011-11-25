<?php

class m110915_195600_geo extends CDbMigration
{
    public function up()
    {
	$sql = "DROP TABLE IF EXISTS `city` ,
`country` ,
`region` ;";
	$this->execute($sql);

	$sql = "CREATE TABLE `geo_rus_region` (
`id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`name` VARCHAR( 255 ) NOT NULL
) ENGINE = MYISAM ;";
	$this->execute($sql);

	$sql = "CREATE TABLE `geo_rus_district` (
`id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`name` VARCHAR( 255 ) NOT NULL ,
`region_id` INT( 11 ) UNSIGNED NOT NULL ,
INDEX ( `region_id` )
) ENGINE = MYISAM ;";
	$this->execute($sql);

	$sql = "CREATE TABLE `geo_rus_settlement` (
`id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`name` VARCHAR( 255 ) NOT NULL ,
`district_id` INT( 11 ) UNSIGNED NULL ,
`region_id` INT( 11 ) UNSIGNED NOT NULL ,
INDEX ( `district_id` ) ,
INDEX ( `region_id` )
) ENGINE = MYISAM ;";
	$this->execute($sql);

	$sql = "CREATE TABLE `geo_rus_street` (
`id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`name` VARCHAR( 255 ) NOT NULL ,
`settlement_id` INT( 11 ) UNSIGNED NOT NULL ,
INDEX ( `settlement_id` )
) ENGINE = MYISAM ;
";
	$this->execute($sql);

	$sql = "ALTER TABLE `club_user` CHANGE `city_id` `settlement_id` INT( 11 ) UNSIGNED NULL ;";
	$this->execute($sql);
    }

    public function down()
    {
        echo "m110915_195600_geo does not support migration down.\n";
        return false;
    }
}