<?php

class m111216_155747_create_edpd_tarif extends CDbMigration
{
	
	private $_table = 'shop_delivery_edpd_tarif';
	
	public function up()
	{
		$sql = "
			CREATE TABLE `shop_delivery_edpd_tarif` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `zone` int(11) NOT NULL,
			  `weight1` int(11) NOT NULL,
			  `weight2` int(11) NOT NULL,
			  `overload` int(11) NOT NULL,
			  `price` int(11) NOT NULL,
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