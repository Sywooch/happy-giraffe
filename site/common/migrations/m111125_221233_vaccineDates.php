<?php
class m111125_221233_vaccineDates extends CDbMigration
{
	public function up()
	{
		$this->execute("
CREATE TABLE IF NOT EXISTS `vaccine` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

INSERT INTO `vaccine` (`id`, `name`) VALUES
(1, 'Энджерикс В'),
(2, 'БЦЖ');

CREATE TABLE IF NOT EXISTS `vaccine_date` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vaccine_id` int(11) NOT NULL,
  `time_from` varchar(4) NOT NULL,
  `time_to` varchar(4) DEFAULT NULL,
  `adult` int(1) DEFAULT NULL,
  `interval` int(1) NOT NULL,
  `every_period` int(1) DEFAULT NULL,
  `age_text` varchar(256) DEFAULT NULL,
  `vaccination_type` int(1) NOT NULL,
  `vote_decline` int(11) NOT NULL,
  `vote_agree` int(11) NOT NULL,
  `vote_did` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

INSERT INTO `vaccine_date` (`id`, `vaccine_id`, `time_from`, `time_to`, `adult`, `interval`, `every_period`, `age_text`, `vaccination_type`, `vote_decline`, `vote_agree`, `vote_did`) VALUES
(1, 1, '0', '', 0, 1, NULL, 'В течение <b>24</b> часов с момента рождения', 3, 1200, 2402, 5401),
(3, 2, '3', '7', 0, 2, NULL, '', 2, 1, 1, 1),
(4, 2, '2', '', NULL, 3, NULL, NULL, 2, 1, 1, 0),
(5, 2, '3', '', 0, 3, NULL, '', 3, 0, 2, 1),
(7, 2, '4,5', '', 0, 3, NULL, '', 1, 0, 1, 0),
(9, 2, '6', '', NULL, 3, NULL, NULL, 2, 2, 0, 0),
(10, 2, '12', '', NULL, 3, NULL, NULL, 2, 0, 0, 0),
(11, 2, '18', '', NULL, 3, NULL, NULL, 2, 0, 0, 0),
(12, 2, '20', '', NULL, 3, NULL, NULL, 2, 0, 0, 0),
(13, 2, '6', '', NULL, 4, NULL, NULL, 2, 0, 0, 0),
(14, 2, '7', '', NULL, 4, NULL, NULL, 2, 0, 0, 0),
(15, 2, '14', '', 0, 4, NULL, '', 2, 0, 2, 0),
(17, 2, '18', '', 1, 4, 10, 'ревакцинация каждые 10 лет от момента последней ревакцинации', 2, 0, 1, 0);

CREATE TABLE IF NOT EXISTS `vaccine_date_disease` (
  `vaccine_date_id` int(11) NOT NULL,
  `vaccine_disease_id` int(11) NOT NULL,
  PRIMARY KEY (`vaccine_date_id`,`vaccine_disease_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `vaccine_date_disease` (`vaccine_date_id`, `vaccine_disease_id`) VALUES
(1, 1),
(3, 3),
(3, 4),
(3, 6),
(7, 1),
(7, 2),
(15, 2),
(15, 3),
(17, 3),
(17, 6);

CREATE TABLE IF NOT EXISTS `vaccine_disease` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `name_genitive` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

INSERT INTO `vaccine_disease` (`id`, `name`, `name_genitive`) VALUES
(1, 'гепатит В', 'гепатита В'),
(2, 'туберкулез', 'туберкулеза'),
(3, 'дифтерия', 'дифтерии'),
(4, 'коклюш', 'коклюша'),
(6, 'столбняк', 'столбняка');

CREATE TABLE IF NOT EXISTS `vaccine_user_vote` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `baby_id` int(11) NOT NULL,
  `vaccine_date_id` int(11) NOT NULL,
  `vote` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

INSERT INTO `vaccine_user_vote` (`id`, `user_id`, `baby_id`, `vaccine_date_id`, `vote`) VALUES
(1, 128, 1, 9, 1),
(2, 128, 1, 5, 2),
(3, 128, 1, 3, 3),
(4, 128, 1, 1, 2),
(5, 128, 1, 4, 2),
(6, 128, 1, 7, 2),
(7, 128, 2, 1, 3),
(8, 128, 2, 5, 2),
(9, 128, 2, 3, 1),
(10, 128, 2, 15, 2),
(11, 128, 1, 17, 2),
(12, 128, 1, 15, 2);");
		
		if(Yii::app()->hasComponent('cache'))
		{
			Yii::app()->getComponent('cache')->flush();
			echo "Cache flused\n";
		}
		
	}
	

	public function down()
	{
		echo "m111125_221233_vaccineDates does not support migration down.\n";
		return false;
		
		$this->execute("");
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
