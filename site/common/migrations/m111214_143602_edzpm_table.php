<?php

class m111214_143602_edzpm_table extends CDbMigration
{
	public function up()
	{
		$sql = "
			CREATE TABLE `shop_delivery_edzpm` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `price` varchar(255) NOT NULL,
			  `city` varchar(255) NOT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		";
		$this->execute($sql);
	}

	public function down()
	{
		$this->dropTable('shop_delivery_edzpm');
	}
}