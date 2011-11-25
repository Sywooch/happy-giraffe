<?php
class m111012_163803_product_articul extends CDbMigration
{
	public function up()
	{
		$this->execute("ALTER TABLE shop_product
	ADD COLUMN product_articul VARCHAR(32) NOT NULL DEFAULT '0' AFTER product_id;
");
		
		if(Yii::app()->hasComponent('cache'))
		{
			Yii::app()->getComponent('cache')->flush();
			echo "Cache flused\n";
		}
		
	}
	

	public function down()
	{
		echo "m111012_163803_product_articul does not support migration down.\n";
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
