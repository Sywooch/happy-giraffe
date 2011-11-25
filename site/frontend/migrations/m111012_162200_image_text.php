<?php
class m111012_162200_image_text extends CDbMigration
{
	public function up()
	{
		$this->execute("ALTER TABLE shop_product_image
	ADD COLUMN image_text TEXT NOT NULL AFTER image_file;
");
		
		if(Yii::app()->hasComponent('cache'))
		{
			Yii::app()->getComponent('cache')->flush();
			echo "Cache flused\n";
		}
		
	}
	

	public function down()
	{
		echo "m111012_162200_image_text does not support migration down.\n";
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
