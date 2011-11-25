<?php
class m111007_153820_shop_product_price extends CDbMigration
{
	public function up()
	{
		$this->execute("ALTER TABLE shop_product
	ADD COLUMN product_price DECIMAL(10,2) NOT NULL AFTER product_title;");
		
		if(Yii::app()->hasComponent('cache'))
		{
			Yii::app()->getComponent('cache')->flush();
			echo "Cache flused\n";
		}
		
	}
	

	public function down()
	{
		echo "m111007_153820_shop_product_price does not support migration down.\n";
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
