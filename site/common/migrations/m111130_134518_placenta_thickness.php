<?php
class m111130_134518_placenta_thickness extends CDbMigration
{
	public function up()
	{
		$this->execute("CREATE TABLE IF NOT EXISTS `placentaThickness` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `week` int(11) NOT NULL,
  `min` float NOT NULL,
  `avg` float NOT NULL,
  `max` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=37 ;

--
-- Dumping data for table `placentaThickness`
--

INSERT INTO `placentaThickness` (`id`, `week`, `min`, `avg`, `max`) VALUES
(2, 7, 7.3, 10.89, 14.4),
(3, 8, 8, 11.74, 15.5),
(4, 9, 8.8, 12.59, 16.6),
(5, 10, 9.5, 13.44, 17.7),
(6, 11, 10.2, 14.29, 18.8),
(7, 12, 10.9, 15.14, 19.8),
(8, 13, 11.6, 16, 20.9),
(9, 14, 12.4, 16.85, 22),
(10, 15, 13.1, 17.7, 23.1),
(11, 16, 13.8, 18.55, 24.3),
(12, 17, 14.5, 19.4, 25.3),
(13, 18, 15.2, 20.26, 26.4),
(14, 19, 16, 21.11, 27.5),
(15, 20, 16.7, 21.98, 28.6),
(16, 21, 17.4, 22.81, 29.7),
(17, 22, 18.1, 23.66, 30.7),
(18, 23, 18.8, 24.52, 31.8),
(19, 24, 19.6, 25.37, 32.9),
(20, 25, 20.3, 26.22, 34),
(21, 26, 21, 27.07, 35.1),
(22, 27, 21.7, 27.92, 36.2),
(23, 28, 22.4, 28.78, 37.3),
(24, 29, 23.2, 29.63, 38.4),
(25, 30, 23.9, 30.48, 39.5),
(26, 31, 24.6, 31.33, 40.6),
(27, 32, 25.3, 32.18, 41.6),
(28, 33, 26, 33.04, 42.7),
(29, 34, 26.8, 33.89, 43.8),
(31, 35, 27.5, 34.74, 44.9),
(32, 36, 28.2, 35.6, 46),
(33, 37, 27.8, 34.35, 45.8),
(34, 38, 27.5, 34.07, 45.5),
(35, 39, 27.1, 33.78, 45.3),
(36, 40, 26.7, 33.5, 45);");
		
		
	}
	

	public function down()
	{
		echo "m111130_134518_placenta_thickness does not support migration down.\n";
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
