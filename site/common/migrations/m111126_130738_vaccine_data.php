<?php
class m111126_130738_vaccine_data extends CDbMigration
{
	public function up()
	{
		$this->execute("TRUNCATE TABLE `vaccine`;
INSERT INTO `vaccine` (`id`, `name`) VALUES
(1, 'Энджерикс В'),
(2, 'БЦЖ');

TRUNCATE TABLE `vaccine_date`;
INSERT INTO `vaccine_date` (`id`, `vaccine_id`, `time_from`, `time_to`, `adult`, `interval`, `every_period`, `age_text`, `vaccination_type`, `vote_decline`, `vote_agree`, `vote_did`) VALUES
(1, 1, '0', '', 0, 1, NULL, 'В течение <b>24</b> часов с момента рождения', 3, 1200, 2401, 5402),
(3, 2, '3', '7', 0, 2, NULL, '', 1, 1, 2, 0),
(4, 1, '1', '', 0, 3, NULL, '', 4, 2, 1, 0),
(5, 2, '3', '', 0, 3, NULL, '', 4, 1, 0, 2),
(7, 2, '4,5', '', 0, 3, NULL, '', 4, 0, 1, 0),
(9, 2, '6', '', 0, 3, NULL, '', 5, 2, 0, 0),
(10, 2, '12', '', 0, 3, NULL, '', 6, 0, 0, 0),
(11, 2, '18', '', 0, 3, NULL, '', 8, 0, 0, 0),
(12, 2, '20', '', 0, 3, NULL, '', 9, 0, 0, 0),
(13, 2, '6', '', 0, 4, NULL, '', 2, 0, 0, 0),
(14, 2, '7', '', 0, 4, NULL, '', 9, 0, 0, 0),
(15, 2, '14', '', 0, 4, NULL, '', 10, 0, 2, 0),
(17, 2, '18', '', 1, 4, 10, 'ревакцинация каждые 10 лет от момента последней ревакцинации', 2, 0, 1, 0),
(18, 1, '2', '', 0, 3, NULL, '', 5, 0, 0, 0),
(19, 1, '3', '', 0, 3, NULL, '', 3, 0, 0, 0),
(20, 1, '12', '', 0, 3, NULL, '', 1, 0, 0, 0),
(21, 2, '7', '', 0, 4, NULL, '', 2, 0, 0, 0),
(22, 2, '14', '', 0, 4, NULL, '', 2, 0, 0, 0),
(23, 2, '14', '', 0, 4, NULL, '', 10, 0, 0, 0);


TRUNCATE TABLE `vaccine_date_disease`;
INSERT INTO `vaccine_date_disease` (`vaccine_date_id`, `vaccine_disease_id`) VALUES
(1, 1),
(3, 2),
(4, 1),
(5, 11),
(7, 3),
(7, 4),
(7, 6),
(7, 7),
(9, 3),
(9, 4),
(9, 6),
(9, 7),
(9, 11),
(10, 11),
(11, 3),
(11, 4),
(11, 6),
(11, 7),
(12, 7),
(13, 8),
(13, 9),
(13, 10),
(14, 3),
(14, 6),
(15, 3),
(15, 6),
(17, 3),
(17, 6),
(18, 1),
(19, 3),
(19, 4),
(19, 6),
(19, 7),
(20, 8),
(20, 9),
(20, 10),
(21, 2),
(22, 2),
(23, 7);

TRUNCATE TABLE `vaccine_user_vote`;

TRUNCATE TABLE `vaccine_disease`;
INSERT INTO `vaccine_disease` (`id`, `name`, `name_genitive`) VALUES
(1, 'гепатит В', 'гепатита В'),
(2, 'туберкулез', 'туберкулеза'),
(3, 'дифтерия', 'дифтерии'),
(4, 'коклюш', 'коклюша'),
(6, 'столбняк', 'столбняка'),
(7, 'полиомиелит', 'полиомиелита'),
(8, 'корь', 'кори'),
(9, 'краснуха', 'краснухи'),
(10, 'эпидемической паротит', 'эпидемического паротита'),
(11, 'вирусный гепатит В', 'вирусного гепатита В');");
		
		if(Yii::app()->hasComponent('cache'))
		{
			Yii::app()->getComponent('cache')->flush();
			echo "Cache flused\n";
		}
		
	}
	

	public function down()
	{
		echo "m111126_130738_vaccine_data does not support migration down.\n";
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
