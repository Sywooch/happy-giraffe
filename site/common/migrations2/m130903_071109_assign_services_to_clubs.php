<?php

class m130903_071109_assign_services_to_clubs extends CDbMigration
{
	public function up()
	{
        $this->execute("
        update `services` set `community_id`=null;
        UPDATE  `services` SET `community_id` = '1' WHERE `services`.`id` =8;
        UPDATE  `services` SET `community_id` = '1' WHERE `services`.`id` =9;
        INSERT INTO `services` (`id`, `title`, `description`, `url`, `photo_id`, `show`, `using_count`, `community_id`) VALUES ('25', 'Женский календарь', '', 'http://www.happy-giraffe.ru/menstrualCycle/', NULL, '0', '0', '1');
        INSERT INTO `services` (`id`, `title`, `description`, `url`, `photo_id`, `show`, `using_count`, `community_id`) VALUES ('26', 'Маршруты', '', 'http://www.happy-giraffe.ru/auto/routes/', NULL, '1', '0', '20');

        UPDATE  `services` SET `community_id` = '2' WHERE `services`.`id` =1;
        UPDATE  `services` SET `community_id` = '2' WHERE `services`.`id` =5;
        UPDATE  `services` SET `community_id` = '2' WHERE `services`.`id` =6;
        UPDATE  `services` SET `community_id` = '2' WHERE `services`.`id` =7;
        UPDATE  `services` SET `community_id` = '2' WHERE `services`.`id` =10;

        UPDATE  `services` SET `community_id` = '3' WHERE `services`.`id` =2;
        UPDATE  `services` SET `community_id` = '3' WHERE `services`.`id` =3;
        UPDATE  `services` SET `community_id` = '3' WHERE `services`.`id` =4;

        UPDATE  `services` SET `community_id` = '7' WHERE `services`.`id` =17;
        UPDATE  `services` SET `community_id` = '7' WHERE `services`.`id` =19;
        UPDATE  `services` SET `community_id` = '7' WHERE `services`.`id` =11;

        UPDATE  `services` SET `community_id` = '8' WHERE `services`.`id` =14;
        UPDATE  `services` SET `community_id` = '8' WHERE `services`.`id` =15;
        UPDATE  `services` SET `community_id` = '8' WHERE `services`.`id` =16;

        UPDATE  `services` SET `community_id` = '16' WHERE `services`.`id` =12;
        UPDATE  `services` SET `community_id` = '16' WHERE `services`.`id` =13;

        INSERT INTO `services__communities` (`service_id`, `community_id`) VALUES
(8, 1),
(9, 1),
(25, 1),
(1, 2),
(5, 2),
(6, 2),
(7, 2),
(8, 2),
(9, 2),
(10, 2),
(1, 3),
(2, 3),
(3, 3),
(4, 3),
(2, 4),
(2, 5),
(2, 6),
(11, 7),
(17, 7),
(19, 7),
(14, 8),
(15, 8),
(16, 8),
(12, 16),
(13, 16),
(26, 18),
(26, 20);

        ");

	}

	public function down()
	{
		echo "m130903_071109_assign_services_to_clubs does not support migration down.\n";
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