<?php

class m111128_184829_hospital_bag extends CDbMigration
{
	public function up()
	{
		$this->execute("
CREATE TABLE `bag_item` (
`id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`name` VARCHAR( 255 ) NOT NULL ,
`description` TEXT NOT NULL ,
`approved` BOOLEAN NOT NULL ,
`for` BOOLEAN NOT NULL ,
`category_id` INT( 11 ) UNSIGNED NOT NULL
) ENGINE = MYISAM ;

CREATE TABLE `bag_category` (
`id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`name` VARCHAR( 255 ) NOT NULL
) ENGINE = MYISAM ;

CREATE TABLE `bag_offer` (
`id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`votes_pro` INT( 11 ) UNSIGNED NOT NULL ,
`votes_con` INT( 11 ) UNSIGNED NOT NULL ,
`item_id` INT( 11 ) UNSIGNED NOT NULL ,
`user_id` INT( 11 ) UNSIGNED NOT NULL
) ENGINE = MYISAM ;

CREATE TABLE `bag_user_vote` (
`offer_id` INT( 11 ) UNSIGNED NOT NULL ,
`user_id` INT( 11 ) UNSIGNED NOT NULL ,
`vote` BOOLEAN NOT NULL ,
UNIQUE (
`offer_id` ,
`user_id`
)
) ENGINE = MYISAM ;

INSERT INTO `happy_giraffe`.`bag_category` (
`id` ,
`name`
)
VALUES (
NULL , 'Документы'
), (
NULL , 'Средства гигиены'
), (
NULL , 'Белье и одежда'
), (
NULL , 'На выписку'
), (
NULL , 'Прочее'
);

INSERT INTO `happy_giraffe`.`bag_item` (`id`, `name`, `description`, `approved`, `for`, `category_id`) VALUES (NULL, 'Паспорт', '', '1', '0', '1'), (NULL, 'Полис обязательного медицинского страхования', '', '1', '0', '1'), (NULL, 'Мыло', '', '1', '0', '2'), (NULL, 'Мыльница', '', '1', '0', '2'), (NULL, 'Халат', '', '1', '0', '3'), (NULL, 'Ночная рубашка', '', '1', '0', '3'), (NULL, 'Одежда', '', '1', '0', '4'), (NULL, 'Обувь', '', '1', '0', '4'), (NULL, 'Кружка', '', '1', '0', '5'), (NULL, 'Ложка', '', '1', '0', '5');
		");
	}

	public function down()
	{
		echo "m111128_184829_hospital_bag does not support migration down.\n";
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