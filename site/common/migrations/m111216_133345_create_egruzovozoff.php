<?php

class m111216_133345_create_egruzovozoff extends CDbMigration
{
	private $_table = 'shop_delivery_egruzovozoff';
	
	public function up()
	{
		$sql = "
			CREATE TABLE `shop_delivery_egruzovozoff` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`weight` int(11) NOT NULL DEFAULT '1',
				`city` varchar(255) NOT NULL,
				`zone` int(11) NOT NULL DEFAULT '0',
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