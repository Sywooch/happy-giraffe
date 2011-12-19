<?php

class m111219_130941_create_pickpoint extends CDbMigration
{
	private $_table = 'shop_delivery_epickpoint';
	
	public function up()
	{
		$sql = "
			CREATE TABLE `shop_delivery_epickpoint` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `city` varchar(255) NOT NULL,
			  `address` varchar(255) NOT NULL,
			  `price` int(11) NOT NULL,
			  `pickpoint_id` varchar(255) NOT NULL,
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