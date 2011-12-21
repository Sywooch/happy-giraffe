<?php

class m111212_132036_edpm_tarif_table_data extends CDbMigration
{
	private $_table = 'shop__delivery_edpm_tarif';
	
	public function up()
	{
		$sql = "INSERT INTO `:shop__delivery_edpm_tarif` (`id`, `order_price_from`, `order_price_to`, `price`) VALUES (NULL, 0, 500, 350);";
		$sql .= "INSERT INTO `:shop__delivery_edpm_tarif` (`id`, `order_price_from`, `order_price_to`, `price`) VALUES (NULL, 500, 1000, 250);";
		$sql .= "INSERT INTO `:shop__delivery_edpm_tarif` (`id`, `order_price_from`, `order_price_to`, `price`) VALUES (NULL, 1000, 1500, 100);";
		$sql .= "INSERT INTO `:shop__delivery_edpm_tarif` (`id`, `order_price_from`, `order_price_to`, `price`) VALUES (NULL, 1000, NULL, 0);";
		$this->execute($sql, array(':table' => $this->_table));
	}

	public function down()
	{
		$this->truncateTable($this->_table);
		$sql = "ALTER TABLE `:table` ENGINE = InnoDB, COMMENT = '', AUTO_INCREMENT = 1";
		$this->execute($sql, array(':table' => $this->_table));
	}
}