<?php

class m111221_213301_edpm extends CDbMigration
{
	public function up()
	{
		$sql = "
			CREATE TABLE IF NOT EXISTS `shop__delivery_edpm` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `price` varchar(255) NOT NULL,
			  `address` varchar(255) NOT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8
		";
		$this->execute($sql);
	}

	public function down()
	{
		echo "m111221_213301_edpm does not support migration down.\n";
		return false;
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