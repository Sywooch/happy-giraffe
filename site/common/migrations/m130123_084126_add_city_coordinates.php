<?php

class m130123_084126_add_city_coordinates extends CDbMigration
{
	public function up()
	{
        $sql = "
        CREATE TABLE IF NOT EXISTS `geo__city_coordinates` (
  `city_id` int(10) unsigned NOT NULL,
  `location_lat` float(11,8) NOT NULL,
  `location_lng` float(11,8) NOT NULL,
  `northeast_lat` float(11,8) NOT NULL,
  `northeast_lng` float(11,8) NOT NULL,
  `southwest_lat` float(11,8) NOT NULL,
  `southwest_lng` float(11,8) NOT NULL,
  PRIMARY KEY (`city_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `geo__city_coordinates`
--
ALTER TABLE `geo__city_coordinates`
  ADD CONSTRAINT `geo__city_coordinates_city` FOREIGN KEY (`city_id`) REFERENCES `geo__city` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
        ";

        $this->execute($sql);
	}

	public function down()
	{
		echo "m130123_084126_add_city_coordinates does not support migration down.\n";
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