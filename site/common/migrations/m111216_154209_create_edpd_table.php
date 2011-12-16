<?php

class m111216_154209_create_edpd_table extends CDbMigration
{
	private $_table = 'shop_delivery_edpd';
	
	public function up()
	{
		$sql = "
			CREATE TABLE `shop_delivery_edpd` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `weight` int(11) NOT NULL,
			  `city` varchar(255) NOT NULL,
			  `zone` int(11) NOT NULL,
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