<?php
class m111020_125245_order_payed extends CDbMigration
{
	public function up()
	{
		$this->execute("ALTER TABLE `shop_order`
	CHANGE COLUMN `order_status` `order_status` TINYINT(3) NOT NULL DEFAULT '1' AFTER `order_id`,
	ADD COLUMN `order_payed` TINYINT(2) UNSIGNED NOT NULL DEFAULT '0' AFTER `order_status`;
");
		
		if(Yii::app()->hasComponent('cache'))
		{
			Yii::app()->getComponent('cache')->flush();
			echo "Cache flused\n";
		}
		
	}
	

	public function down()
	{
		echo "m111020_125245_order_payed does not support migration down.\n";
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
