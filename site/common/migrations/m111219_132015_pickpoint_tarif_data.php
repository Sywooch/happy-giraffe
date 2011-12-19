<?php

class m111219_132015_pickpoint_tarif_data extends CDbMigration
{
	private $_table = 'shop_delivery_epickpointtarif';
	
	public function up()
	{
		$sql = "
			INSERT INTO `shop_delivery_epickpointtarif` (`id`, `price`, `city`, `pickgoname`) VALUES 
			  (1, 200, 'Москва', 'moscow'),
			  (2, 200, 'Московская область', 'mosoblast'),
			  (3, 240, 'Санкт-Петербург', 'petersburg'),
			  (4, 250, 'Псков', 'pskov'),
			  (5, 250, 'Саратов', 'saratov'),
			  (6, 250, 'Екатеринбург ', 'ekaterinburg'),
			  (7, 250, 'Казань', 'kazan'),
			  (8, 250, 'Краснодар', 'krasnodar'),
			  (9, 250, 'Нижний Новгород', 'nijniy_novgorod'),
			  (10, 250, 'Ростов-на-Дону', 'rostov-na-donu'),
			  (11, 250, 'Самара', 'Samara'),
			  (12, 250, 'Уфа', 'yfa'),
			  (13, 280, 'Новосибирск', 'novosibirsk'),
			  (14, 310, 'Красноярск', 'krasnoyarsk'),
			  (15, 310, 'Архангельск', 'archangelsk'),
			  (16, 310, 'Волгоград', 'volgograd'),
			  (17, 310, 'Воронеж', 'voronezh'),
			  (18, 310, 'Калуга', 'kaluga'),
			  (19, 310, 'Омск', 'omsk'),
			  (20, 310, 'Пермь', 'perm'),
			  (21, 310, 'Тольятти', 'Tolyatti'),
			  (22, 310, 'Ярославль', 'yaroslavl');
		";
		$this->execute($sql);
	}

	public function down()
	{
		$this->truncateTable($this->_table);
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