<?php

class m120905_092706_serviceCategories extends CDbMigration
{
	public function up()
	{
        $this->execute("CREATE TABLE IF NOT EXISTS `service_categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

INSERT INTO `service_categories` (`id`, `title`) VALUES
(1, 'Сервисы для мам и пап'),
(2, 'Сервисы для беременных'),
(3, 'Сервисы для кулинаров');

ALTER TABLE  `services` ADD  `category_id` INT( 11 ) UNSIGNED NOT NULL;

UPDATE  `happy_giraffe`.`services` SET  `category_id` =  '1' WHERE  `services`.`id` IN (1,2,3,4);
UPDATE  `happy_giraffe`.`services` SET  `category_id` =  '2' WHERE  `services`.`id` IN (5,6,7,8,9);

ALTER TABLE  `services` ADD INDEX (  `category_id` );

ALTER TABLE  `services` ADD FOREIGN KEY (  `category_id` ) REFERENCES  `happy_giraffe`.`service_categories` (
`id`
) ON DELETE CASCADE ON UPDATE CASCADE ;
");
	}

	public function down()
	{
		echo "m120905_092706_serviceCategories does not support migration down.\n";
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