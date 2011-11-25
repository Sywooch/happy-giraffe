<?php
class m111012_153108_product_sell_buy_price extends CDbMigration
{
	public function up()
	{
		$this->execute("ALTER TABLE shop_product
	ADD COLUMN product_buy_price DECIMAL(10,2) NOT NULL AFTER product_price,
	ADD COLUMN product_sell_price DECIMAL(10,2) NOT NULL AFTER product_buy_price;
");
		
		if(Yii::app()->hasComponent('cache'))
		{
			Yii::app()->getComponent('cache')->flush();
			echo "Cache flused\n";
		}
		
	}
	

	public function down()
	{
		echo "m111012_153108_product_sell_buy_price does not support migration down.\n";
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
