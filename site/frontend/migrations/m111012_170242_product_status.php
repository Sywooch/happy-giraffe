<?php
class m111012_170242_product_status extends CDbMigration
{
	public function up()
	{
		$this->execute("ALTER TABLE shop_product
	CHANGE COLUMN product_is_show product_status TINYINT(2) UNSIGNED NOT NULL DEFAULT '1' AFTER product_rate;");
		
		if(Yii::app()->hasComponent('cache'))
		{
			Yii::app()->getComponent('cache')->flush();
			echo "Cache flused\n";
		}
		
	}
	

	public function down()
	{
		echo "m111012_170242_product_status does not support migration down.\n";
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
