<?php

class m120730_094311_calendars extends CDbMigration
{
	public function up()
	{
        $this->execute("CREATE TABLE `happy_giraffe`.`calendar__periods` (
`id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`title` VARCHAR( 255 ) NOT NULL ,
`text` TEXT NOT NULL ,
`features` TEXT NULL ,
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
        $this->execute("INSERT INTO `calendar__periods` (`id`, `title`, `text`, `features`, `calendar`) VALUES
(1, 'Новорожденный', '', '', 0),
(2, '1-я неделя', '', '', 0),
(3, '2-я неделя', '', '', 0),
(4, '3-я неделя', '', '', 0),
(5, '1-й месяц', '', '', 0),
(6, '2-й месяц', '', '', 0),
(7, '3-й месяц', '', '', 0),
(8, '4-й месяц', '', '', 0),
(9, '5-й месяц', '', '', 0),
(10, '6-й месяц', '', '', 0),
(11, '7-й месяц', '', '', 0),
(12, '8-й месяц', '', '', 0),
(13, '9-й месяц', '', '', 0),
(14, '10-й месяц', '', '', 0),
(15, '11-й месяц', '', '', 0),
(16, '12-й месяц', '', '', 0),
(17, '15-й месяц', '', '', 0),
(18, '18-й месяц', '', '', 0),
(19, '21-й месяц', '', '', 0),
(20, '2 года', '', '', 0),
(21, '2,5 года', '', '', 0),
(22, '3 года', '', '', 0),
(23, 'Дошкольный возраст', '', '', 0),
(24, 'Младший школьник', '', '', 0),
(25, 'Подросток', '', '', 0),
(26, 'Юношеский возраст', '', '', 0),
(27, 'Планирование', '', NULL, 1),
(28, '1-я неделя', '', NULL, 1),
(29, '2-я неделя', '', NULL, 1),
(30, '3-я неделя', '', NULL, 1),
(31, '4-я неделя', '', NULL, 1),
(32, '5-я неделя', '', NULL, 1),
(33, '6-я неделя', '', NULL, 1),
(34, '7-я неделя', '', NULL, 1),
(35, '8-я неделя', '', NULL, 1),
(36, '9-я неделя', '', NULL, 1),
(37, '10-я неделя', '', NULL, 1),
(38, '11-я неделя', '', NULL, 1),
(39, '12-я неделя', '', NULL, 1),
(40, '13-я неделя', '', NULL, 1),
(41, '14-я неделя', '', NULL, 1),
(42, '15-я неделя', '', NULL, 1),
(43, '16-я неделя', '', NULL, 1),
(44, '17-я неделя', '', NULL, 1),
(45, '18-я неделя', '', NULL, 1),
(46, '19-я неделя', '', NULL, 1),
(47, '20-я неделя', '', NULL, 1),
(48, '21-я неделя', '', NULL, 1),
(49, '22-я неделя', '', NULL, 1),
(50, '23-я неделя', '', NULL, 1),
(51, '24-я неделя', '', NULL, 1),
(52, '25-я неделя', '', NULL, 1),
(53, '26-я неделя', '', NULL, 1),
(54, '27-я неделя', '', NULL, 1),
(55, '28-я неделя', '', NULL, 1),
(56, '29-я неделя', '', NULL, 1),
(57, '30-я неделя', '', NULL, 1),
(58, '31-я неделя', '', NULL, 1),
(59, '32-я неделя', '', NULL, 1),
(60, '33-я неделя', '', NULL, 1),
(61, '34-я неделя', '', NULL, 1),
(62, '35-я неделя', '', NULL, 1),
(63, '36-я неделя', '', NULL, 1),
(64, '37-я неделя', '', NULL, 1),
(65, '38-я неделя', '', NULL, 1),
(66, '39-я неделя', '', NULL, 1),
(67, '40-я неделя', '', NULL, 1),
(68, 'Роды', '', NULL, 1);");
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