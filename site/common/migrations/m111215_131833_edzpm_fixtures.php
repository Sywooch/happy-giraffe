<?php

class m111215_131833_edzpm_fixtures extends CDbMigration
{
	public function up()
	{
		$sql = "
		INSERT INTO `shop_delivery_edzpm_zone` (`id`, `title`, `price`) VALUES 
		  (1, 'First Zone', 3000),
		  (2, 'Second zone', 5000),
		  (3, 'Third Zone', 9000);
		";
		$this->execute($sql);
		$sql = "
		INSERT INTO `shop_delivery_edzpm_city_zone_link` (`id`, `city_id`, `edzpm_zone_id`) VALUES 
		  (3, 65541, 1),
		  (4, 65775, 2),
		  (5, 65598, 3);
		";
		$this->execute($sql);
	}

	public function down()
	{
		echo "m111215_131833_edzpm_fixtures does not support migration down.\n";
		return false;
	}
}