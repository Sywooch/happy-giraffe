<?php

class m111212_124721_edpm_table extends CDbMigration {

	private $_table = 'shop__delivery_edpm_tarif';

	public function up() {
		$sql = "
			CREATE TABLE `:table` (
			  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
			  `order_price_from` INTEGER(11) NOT NULL,
			  `order_price_to` INTEGER(11) DEFAULT NULL,
			  `price` INTEGER(11) NOT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
		";
		$this->execute($sql, array(':table' => $this->_table));
	}

	public function down() {
		$this->dropTable($this->_table);
	}

}