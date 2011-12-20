<?php
class m111207_091649_menstrual_cycle extends CDbMigration
{
	public function up()
	{
		$this->execute("CREATE TABLE IF NOT EXISTS `menstrual_cycle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cycle` int(1) NOT NULL,
  `menstruation` int(1) NOT NULL,
  `safety_sex` int(1) NOT NULL,
  `ovulation_probable` int(1) NOT NULL,
  `ovulation_most_probable` int(1) NOT NULL,
  `ovulation_can` int(1) NOT NULL,
  `pms` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=57 ;

CREATE TABLE IF NOT EXISTS `menstrual_user_cycle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `cycle` int(1) NOT NULL,
  `menstruation` int(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

INSERT INTO `menstrual_cycle` (`id`, `cycle`, `menstruation`, `safety_sex`, `ovulation_probable`, `ovulation_most_probable`, `ovulation_can`, `pms`) VALUES
(1, 21, 7, 0, 3, 1, 3, 5),
(2, 21, 6, 0, 3, 1, 3, 6),
(3, 21, 5, 0, 4, 1, 3, 6),
(4, 21, 4, 0, 5, 1, 3, 6),
(5, 21, 3, 1, 5, 1, 3, 6),
(6, 22, 7, 0, 4, 1, 3, 5),
(7, 22, 6, 0, 4, 1, 3, 6),
(8, 22, 5, 0, 5, 1, 3, 6),
(9, 22, 4, 1, 5, 1, 3, 6),
(10, 22, 3, 2, 5, 1, 3, 6),
(11, 23, 7, 0, 3, 1, 3, 7),
(12, 23, 6, 0, 4, 1, 3, 7),
(13, 23, 5, 0, 5, 1, 3, 7),
(14, 23, 4, 1, 5, 1, 3, 7),
(15, 23, 3, 2, 5, 1, 3, 7),
(16, 24, 7, 0, 4, 1, 3, 7),
(17, 24, 6, 0, 5, 1, 3, 7),
(18, 24, 5, 1, 5, 1, 3, 7),
(19, 24, 4, 2, 5, 1, 3, 7),
(20, 24, 3, 3, 5, 1, 3, 7),
(21, 25, 7, 0, 4, 1, 3, 8),
(22, 25, 6, 0, 5, 1, 3, 8),
(23, 25, 5, 1, 5, 1, 3, 8),
(24, 25, 4, 2, 5, 1, 3, 8),
(25, 25, 3, 3, 5, 1, 3, 8),
(26, 26, 7, 0, 5, 1, 3, 8),
(27, 26, 6, 1, 5, 1, 3, 8),
(28, 26, 5, 2, 5, 1, 3, 8),
(29, 26, 4, 3, 5, 1, 3, 8),
(30, 26, 3, 4, 5, 1, 3, 8),
(31, 27, 7, 0, 5, 1, 3, 8),
(32, 27, 6, 1, 5, 1, 3, 8),
(33, 27, 5, 2, 5, 1, 3, 8),
(34, 27, 4, 3, 5, 1, 3, 8),
(35, 27, 3, 4, 5, 1, 3, 8),
(36, 28, 7, 1, 5, 1, 3, 8),
(37, 28, 6, 2, 5, 1, 3, 8),
(38, 28, 5, 3, 5, 1, 3, 8),
(39, 28, 4, 4, 5, 1, 3, 8),
(40, 28, 3, 5, 5, 1, 3, 8),
(41, 29, 7, 1, 5, 1, 3, 8),
(42, 29, 6, 2, 5, 1, 3, 8),
(43, 29, 5, 3, 5, 1, 3, 8),
(44, 29, 4, 4, 5, 1, 3, 8),
(45, 29, 3, 5, 5, 1, 3, 8),
(46, 30, 7, 2, 5, 1, 3, 9),
(47, 30, 6, 3, 5, 1, 3, 9),
(48, 30, 5, 4, 5, 1, 3, 9),
(49, 30, 4, 5, 5, 1, 3, 9),
(50, 30, 3, 6, 5, 1, 3, 9),
(51, 31, 7, 2, 5, 1, 3, 9),
(52, 31, 6, 3, 5, 1, 3, 9),
(53, 31, 5, 4, 5, 1, 3, 9),
(54, 31, 4, 5, 5, 1, 3, 9),
(55, 31, 3, 6, 5, 1, 3, 9),
(56, 32, 7, 3, 5, 1, 3, 9),
(57, 32, 6, 4, 5, 1, 3, 9),
(58, 32, 5, 5, 5, 1, 3, 9),
(59, 32, 4, 6, 5, 1, 3, 9),
(60, 32, 3, 7, 5, 1, 3, 9),
(61, 33, 7, 3, 5, 1, 3, 10),
(62, 33, 6, 4, 5, 1, 3, 10),
(63, 33, 5, 5, 5, 1, 3, 10),
(64, 33, 4, 6, 5, 1, 3, 10),
(65, 33, 3, 7, 5, 1, 3, 10),
(66, 34, 7, 4, 5, 1, 3, 10),
(67, 34, 6, 5, 5, 1, 3, 10),
(68, 34, 5, 6, 5, 1, 3, 10),
(69, 34, 4, 7, 5, 1, 3, 10),
(70, 34, 3, 8, 5, 1, 3, 10),
(71, 35, 7, 4, 5, 1, 3, 10),
(72, 35, 6, 5, 5, 1, 3, 10),
(73, 35, 5, 6, 5, 1, 3, 10),
(74, 35, 4, 7, 5, 1, 3, 10),
(75, 35, 3, 8, 5, 1, 3, 10);");
		
		if(Yii::app()->hasComponent('cache'))
		{
			Yii::app()->getComponent('cache')->flush();
			echo "Cache flused\n";
		}
		
	}
	

	public function down()
	{
        $this->dropTable('menstrual_cycle');
        $this->dropTable('menstrual_user_cycle');
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
