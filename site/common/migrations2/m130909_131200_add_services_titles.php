<?php

class m130909_131200_add_services_titles extends CDbMigration
{
    private $_table = 'community__clubs';
	public function up()
	{
        $this->addColumn($this->_table, 'services_title', 'varchar(200) after `services_description`');
        $this->execute("
        UPDATE `community__clubs` SET `services_title` = 'Сервисы для планирующих' WHERE  `community__clubs`.`id` =1;
        UPDATE `community__clubs` SET `services_title` = 'Сервисы для беременных' WHERE  `community__clubs`.`id` =2;
        UPDATE `community__clubs` SET `services_title` = 'Сервисы для родителей' WHERE  `community__clubs`.`id` =3;
        UPDATE `community__clubs` SET `services_title` = 'Сервисы для родителей' WHERE  `community__clubs`.`id` =4;
        UPDATE `community__clubs` SET `services_title` = 'Сервисы для родителей' WHERE  `community__clubs`.`id` =5;
        UPDATE `community__clubs` SET `services_title` = 'Сервисы для родителей' WHERE  `community__clubs`.`id` =6;
        UPDATE `community__clubs` SET `services_title` = 'Сервисы для кулинаров' WHERE  `community__clubs`.`id` =7;
        UPDATE `community__clubs` SET `services_title` = 'Сервисы для хозяев' WHERE  `community__clubs`.`id` =8;
        UPDATE `community__clubs` SET `services_title` = 'Сервисы для рукодельниц' WHERE  `community__clubs`.`id` =16;
        UPDATE `community__clubs` SET `services_title` = 'Сервисы для водителей' WHERE  `community__clubs`.`id` =18;
        UPDATE `community__clubs` SET `services_title` = 'Сервисы для туристов' WHERE  `community__clubs`.`id` =20;
        ");
	}

	public function down()
	{
		$this->dropColumn($this->_table,'services_title');
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