<?php

class m111216_133645_create_egruzovozoff_tarif extends CDbMigration
{
	
	private $_table = 'shop_delivery_egruzovozofftarif';
	
	public function up()
	{
		$sql = "
			CREATE TABLE `shop_delivery_egruzovozofftarif` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `price` int(11) NOT NULL,
			  `city` varchar(255) NOT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		";
		$this->execute($sql);
	}

	public function down()
	{
		$this->dropTable($this->_table);
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