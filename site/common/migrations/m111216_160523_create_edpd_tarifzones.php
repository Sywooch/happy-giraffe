<?php

class m111216_160523_create_edpd_tarifzones extends CDbMigration
{
	private $_table = 'shop_delivery_edpd_tarifzones';
	
	public function up()
	{
		$sql = "
			CREATE TABLE `shop_delivery_edpd_tarifzones` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `zone` int(11) NOT NULL,
			  `city` int(11) NOT NULL,
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