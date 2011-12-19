<?php

class m111219_110934_rename_edpd_tarif_data extends CDbMigration
{
	private $_table = 'shop_delivery_edpd_tarif';
	
	public function up()
	{
		$sql = "
			INSERT INTO `shop_delivery_edpd_tarif` (`id`, `zone`, `weight1`, `weight2`, `overload`, `price`) VALUES 
			  (1, 0, 0, 2, 15, 280),
			  (2, 0, 3, 5, 15, 300),
			  (3, 0, 6, 10, 15, 350),
			  (4, 0, 11, 20, 15, 400),
			  (5, 0, 21, 30, 15, 500),
			  (26, 1, 0, 2, 20, 350),
			  (27, 1, 3, 5, 20, 450),
			  (28, 1, 6, 10, 20, 500),
			  (29, 1, 11, 20, 20, 700),
			  (30, 1, 21, 30, 20, 1000),
			  (31, 2, 0, 2, 60, 400),
			  (32, 2, 3, 5, 60, 500),
			  (33, 2, 6, 10, 60, 800),
			  (34, 2, 11, 20, 60, 1200),
			  (35, 2, 21, 30, 60, 1800),
			  (36, 3, 0, 2, 80, 400),
			  (37, 3, 3, 5, 80, 600),
			  (38, 3, 6, 10, 80, 900),
			  (39, 3, 11, 20, 80, 1500),
			  (40, 3, 21, 30, 80, 2200),
			  (41, 4, 0, 2, 100, 450),
			  (42, 4, 3, 5, 100, 700),
			  (43, 4, 6, 10, 100, 1200),
			  (44, 4, 11, 20, 100, 2000),
			  (45, 4, 21, 30, 100, 3400),
			  (46, 5, 0, 2, 160, 550),
			  (47, 5, 3, 5, 160, 950),
			  (48, 5, 6, 10, 160, 1600),
			  (49, 5, 11, 20, 160, 3000),
			  (50, 5, 21, 30, 160, 5000);
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