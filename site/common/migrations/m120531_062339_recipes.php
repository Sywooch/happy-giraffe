<?php

class m120531_062339_recipes extends CDbMigration
{
	public function up()
	{
        $this->execute("
CREATE TABLE IF NOT EXISTS `cook__cuisines` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=98 ;

INSERT INTO `cook__cuisines` (`id`, `title`) VALUES
(1, 'Абхазская кухня'),
(2, 'Австралийская кухня'),
(3, 'Австрийская кухня'),
(4, 'Азербайджанская кухня'),
(5, 'Алжирская кухня'),
(6, 'Американская кухня'),
(7, 'Английская кухня'),
(8, 'Аргентинская кухня'),
(9, 'Армянская кухня'),
(10, 'Африканская кухня'),
(11, 'Башкирская кухня'),
(12, 'Белорусская кухня'),
(13, 'Бельгийская кухня'),
(14, 'Болгарская кухня'),
(15, 'Бразильская кухня'),
(16, 'Бурятская кухня'),
(17, 'Венгерская кухня'),
(18, 'Вьетнамская кухня'),
(19, 'Голландская кухня'),
(20, 'Греческая кухня'),
(21, 'Грузинская кухня'),
(22, 'Датская кухня'),
(23, 'Еврейская кухня'),
(24, 'Египетская кухня'),
(25, 'Индийская кухня'),
(26, 'Иорданская кухня'),
(27, 'Иракская кухня'),
(28, 'Иранская кухня'),
(29, 'Ирландская кухня'),
(30, 'Испанская кухня'),
(31, 'Итальянская кухня'),
(32, 'Кавказская кухня'),
(33, 'Казахская кухня'),
(34, 'Калмыцкая кухня'),
(35, 'Канадская кухня'),
(36, 'Караимская кухня'),
(37, 'Карельская кухня'),
(38, 'Кипрская кухня'),
(39, 'Киргизская кухня'),
(40, 'Китайская кухня'),
(41, 'Корейская кухня'),
(42, 'Кубинская кухня'),
(43, 'Кухня Индонезии'),
(44, 'Кухня Луизианы'),
(45, 'Кухня Малайзии'),
(46, 'Кухня Туниса'),
(47, 'Кухня Ямайки'),
(48, 'Кхмерская кухня'),
(49, 'Латвийская кухня'),
(50, 'Латышская кухня'),
(51, 'Ливанская кухня'),
(52, 'Литовская кухня'),
(53, 'Мальтийская кухня'),
(54, 'Марийская кухня'),
(55, 'Марокканская кухня'),
(56, 'Мексиканская кухня'),
(57, 'Молдавская кухня'),
(58, 'Монгольская кухня'),
(59, 'Мордовская кухня'),
(60, 'Немецкая кухня'),
(61, 'Непальская кухня'),
(62, 'Норвежская кухня'),
(63, 'Польская кухня'),
(64, 'Португальская кухня'),
(65, 'Прибалтийская кухня'),
(66, 'Румынская кухня'),
(67, 'Русская кухня'),
(68, 'Сенегальская кухня'),
(69, 'Сербская кухня'),
(70, 'Сирийская кухня'),
(71, 'Словацкая кухня'),
(72, 'Таджикская кухня'),
(73, 'Таиландская кухня'),
(74, 'Тайская кухня'),
(75, 'Татарская кухня'),
(76, 'Тувинская кухня'),
(77, 'Турецкая кухня'),
(78, 'Туркменская кухня'),
(79, 'Удмуртская кухня'),
(80, 'Узбекская кухня'),
(81, 'Украинская кухня'),
(82, 'Уругвайская кухня'),
(83, 'Финская кухня'),
(84, 'Французская кухня'),
(85, 'Хорватская кухня'),
(86, 'Чехословацкая кухня'),
(87, 'Чечено-ингушская кухня'),
(88, 'Чешская кухня'),
(89, 'Чилийская кухня'),
(90, 'Чувашская кухня'),
(91, 'Шведская кухня'),
(92, 'Швейцарская кухня'),
(93, 'Шотландская кухня'),
(94, 'Эквадорская кухня'),
(95, 'Эстонская кухня'),
(96, 'Югославская кухня'),
(97, 'Японская кухня');
        ");

        $this->execute("
CREATE TABLE IF NOT EXISTS `cook__recipes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `photo_id` int(11) unsigned DEFAULT NULL,
  `preparation_duration` smallint(3) unsigned DEFAULT NULL,
  `cooking_duration` smallint(3) unsigned DEFAULT NULL,
  `servings` tinyint(2) unsigned DEFAULT NULL,
  `advice` text NOT NULL,
  `text` text,
  `cuisine_id` int(11) unsigned DEFAULT NULL,
  `type` tinyint(2) unsigned NOT NULL,
  `method` tinyint(2) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `photo_id` (`photo_id`),
  KEY `cuisine_id` (`cuisine_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `cook__recipes`
  ADD CONSTRAINT `cook__recipes_ibfk_1` FOREIGN KEY (`photo_id`) REFERENCES `album__photos` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `cook__recipes_ibfk_2` FOREIGN KEY (`cuisine_id`) REFERENCES `cook__cuisines` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
        ");

        $this->execute("
CREATE TABLE IF NOT EXISTS `cook__recipe_ingredients` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `recipe_id` int(11) unsigned NOT NULL,
  `ingredient_id` int(11) unsigned NOT NULL,
  `unit_id` int(11) unsigned NOT NULL,
  `value` decimal(5,2) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `recipe_id` (`recipe_id`),
  KEY `ingredient_id` (`ingredient_id`),
  KEY `unit_id` (`unit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `cook__recipe_ingredients`
  ADD CONSTRAINT `cook__recipe_ingredients_ibfk_3` FOREIGN KEY (`unit_id`) REFERENCES `cook__units` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cook__recipe_ingredients_ibfk_1` FOREIGN KEY (`recipe_id`) REFERENCES `cook__recipes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cook__recipe_ingredients_ibfk_2` FOREIGN KEY (`ingredient_id`) REFERENCES `cook__ingredients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
        ");

        $this->execute("
CREATE TABLE IF NOT EXISTS `cook__recipe_steps` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `recipe_id` int(11) unsigned NOT NULL,
  `photo_id` int(11) unsigned DEFAULT NULL,
  `text` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `recipe_id` (`recipe_id`),
  KEY `photo_id` (`photo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `cook__recipe_steps`
  ADD CONSTRAINT `cook__recipe_steps_ibfk_2` FOREIGN KEY (`recipe_id`) REFERENCES `cook__recipes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cook__recipe_steps_ibfk_1` FOREIGN KEY (`photo_id`) REFERENCES `album__photos` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
        ");
	}

	public function down()
	{
		echo "m120531_062339_recipes does not support migration down.\n";
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