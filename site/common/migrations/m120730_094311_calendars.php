<?php

class m120730_094311_calendars extends CDbMigration
{
	public function up()
	{
        $this->execute("CREATE TABLE `happy_giraffe`.`calendar__periods` (
`id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`title` VARCHAR( 255 ) NOT NULL ,
`text` TEXT NOT NULL ,
`features` TEXT NOT NULL ,
`calendar` TINYINT( 1 ) UNSIGNED NOT NULL
) ENGINE = InnoDB;
");
        $this->execute("CREATE TABLE `happy_giraffe`.`calendar__periods_contents` (
`period_id` INT( 11 ) UNSIGNED NOT NULL ,
`content_id` INT( 11 ) UNSIGNED NOT NULL
) ENGINE = InnoDB;
");
        $this->execute("ALTER TABLE `calendar__periods_contents` ADD INDEX ( `period_id` ) ;");
        $this->execute("ALTER TABLE `calendar__periods_contents` ADD INDEX ( `content_id` ) ;");
        $this->execute("ALTER TABLE `calendar__periods_contents` ADD FOREIGN KEY ( `period_id` ) REFERENCES `happy_giraffe`.`calendar__periods` (
`id`
) ON DELETE CASCADE ON UPDATE CASCADE ;

ALTER TABLE `calendar__periods_contents` ADD FOREIGN KEY ( `content_id` ) REFERENCES `happy_giraffe`.`community__contents` (
`id`
) ON DELETE CASCADE ON UPDATE CASCADE ;");
        $this->execute("CREATE TABLE `happy_giraffe`.`calendar__periods_communities` (
`period_id` INT( 11 ) UNSIGNED NOT NULL ,
`community_id` INT( 11 ) UNSIGNED NOT NULL
) ENGINE = InnoDB;
");
        $this->execute("ALTER TABLE `calendar__periods_communities` ADD INDEX ( `period_id` ) ;");
        $this->execute("ALTER TABLE `calendar__periods_communities` ADD INDEX ( `community_id` );");
        $this->execute("ALTER TABLE `calendar__periods_communities` ADD FOREIGN KEY ( `period_id` ) REFERENCES `happy_giraffe`.`calendar__periods` (
`id`
) ON DELETE CASCADE ON UPDATE CASCADE ;

ALTER TABLE `calendar__periods_communities` ADD FOREIGN KEY ( `community_id` ) REFERENCES `happy_giraffe`.`community__communities` (
`id`
) ON DELETE CASCADE ON UPDATE CASCADE ;");
        $this->execute("CREATE TABLE `happy_giraffe`.`services` (
`id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`title` VARCHAR( 255 ) NOT NULL ,
`description` TEXT NOT NULL
) ENGINE = InnoDB;
");
        $this->execute("CREATE TABLE `happy_giraffe`.`calendar__periods_services` (
`period_id` INT( 11 ) UNSIGNED NOT NULL ,
`service_id` INT( 11 ) UNSIGNED NOT NULL
) ENGINE = InnoDB;");
        $this->execute("ALTER TABLE `calendar__periods_services` ADD INDEX ( `period_id` ) ;");
        $this->execute("ALTER TABLE `calendar__periods_services` ADD INDEX ( `service_id` ) ;");
        $this->execute("ALTER TABLE `calendar__periods_services` ADD FOREIGN KEY ( `period_id` ) REFERENCES `happy_giraffe`.`calendar__periods` (
`id`
) ON DELETE CASCADE ON UPDATE CASCADE ;

ALTER TABLE `calendar__periods_services` ADD FOREIGN KEY ( `service_id` ) REFERENCES `happy_giraffe`.`services` (
`id`
) ON DELETE CASCADE ON UPDATE CASCADE ;
");
        $this->execute("INSERT INTO `happy_giraffe`.`auth__items` (
`name` ,
`type` ,
`description` ,
`bizrule` ,
`data`
)
VALUES (
'calendar_baby', '0', 'Управление календарём малыша', NULL , NULL
), (
'calendar_pregnancy', '0', 'Управление календарём беременности', NULL , NULL
);");
	}

	public function down()
	{
		echo "m120730_094311_calendars does not support migration down.\n";
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