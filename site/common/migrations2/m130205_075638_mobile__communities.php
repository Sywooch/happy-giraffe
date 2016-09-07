<?php

class m130205_075638_mobile__communities extends CDbMigration
{
	public function up()
	{
        $this->execute("CREATE TABLE IF NOT EXISTS `mobile__communities` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `mobile__communities_communities` (
  `mobile_community_id` int(11) unsigned NOT NULL,
  `community_id` int(11) unsigned NOT NULL,
  KEY `mobile_community_id` (`mobile_community_id`),
  KEY `community_id` (`community_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `mobile__communities_communities`
  ADD CONSTRAINT `mobile__communities_communities_ibfk_2` FOREIGN KEY (`community_id`) REFERENCES `community__communities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mobile__communities_communities_ibfk_1` FOREIGN KEY (`mobile_community_id`) REFERENCES `mobile__communities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

INSERT INTO `mobile__communities` (`id`, `title`) VALUES (NULL, 'Беременность и роды'), (NULL, 'Дети от 0 до 3 лет'), (NULL, 'Дошкольники'), (NULL, 'Школьники'), (NULL, 'Свадьба'), (NULL, 'Отношения'), (NULL, 'Интерьер и дизайн'), (NULL, 'Домашние хлопоты'), (NULL, 'Загородная жизнь'), (NULL, 'Рукоделие'), (NULL, 'Цветоводство'), (NULL, 'Красота'), (NULL, 'Мода и шоппинг'), (NULL, 'Путешествия с семьей'), (NULL, 'Праздники');

INSERT INTO `mobile__communities_communities` (`mobile_community_id`, `community_id`) VALUES ('1', '1'), ('1', '2'), ('1', '3'), ('2', '4'), ('2', '5'), ('2', '6'), ('2', '7'), ('2', '8'), ('2', '9'), ('2', '10'), ('2', '11'), ('3', '12'), ('3', '13'), ('3', '14'), ('4', '15'), ('4', '16'), ('4', '17'), ('4', '18'), ('5', '32'), ('6', '31'), ('7', '26'), ('8', '28'), ('9', '34'), ('10', '24'), ('10', '25'), ('11', '35'), ('12', '29'), ('13', '30'), ('14', '21'), ('15', '20');
");

	}

	public function down()
	{
		echo "m130205_075638_mobile__communities does not support migration down.\n";
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