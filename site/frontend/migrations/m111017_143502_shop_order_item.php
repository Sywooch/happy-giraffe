<?php
class m111017_143502_shop_order_item extends CDbMigration
{
	public function up()
	{
		$this->execute("CREATE TABLE shop_order_item (
	item_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	item_order_id INT(10) UNSIGNED NOT NULL,
	item_product_id INT(10) UNSIGNED NOT NULL,
	item_product_count INT(10) UNSIGNED NOT NULL,
	item_product_cost DECIMAL(12,2) UNSIGNED NOT NULL,
	item_product_title VARCHAR(250) NOT NULL,
	item_product_property TEXT NULL,
	PRIMARY KEY (item_id),
	INDEX item_order_id (item_order_id)
)
COLLATE='utf8_general_ci'
ENGINE=MyISAM;");
		
		if(Yii::app()->hasComponent('cache'))
		{
			Yii::app()->getComponent('cache')->flush();
			echo "Cache flused\n";
		}
		
	}
	

	public function down()
	{
		echo "m111017_143502_shop_order_item does not support migration down.\n";
		return false;
		
		$this->execute("");
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
