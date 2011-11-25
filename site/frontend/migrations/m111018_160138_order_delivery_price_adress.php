<?php
class m111018_160138_order_delivery_price_adress extends CDbMigration
{
	public function up()
	{
		$this->execute("ALTER TABLE `shop_order`
	ADD COLUMN `order_price_delivery` DECIMAL(12,2) UNSIGNED NOT NULL AFTER `order_price_total`,
	ADD COLUMN `order_delivery_adress` TEXT NULL AFTER `order_description`;");
		
		if(Yii::app()->hasComponent('cache'))
		{
			Yii::app()->getComponent('cache')->flush();
			echo "Cache flused\n";
		}
		
	}
	

	public function down()
	{
		echo "m111018_160138_order_delivery_price_adress does not support migration down.\n";
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
