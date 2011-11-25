<?php
class m111005_110452_shop_new_product_structure extends CDbMigration
{
	public function up()
	{
		$this->execute("ALTER TABLE shop_product
	ADD COLUMN product_category_id INT(10) UNSIGNED NOT NULL AFTER product_id,
	DROP COLUMN product_type_id,
	DROP COLUMN product_attribute_set_id,
	ADD INDEX product_category_id (product_category_id);");
		
		if(Yii::app()->hasComponent('cache'))
			Yii::app()->getComponent('cache')->flush();
		
		$this->clearAssets();
	}
	
	private function clearAssets()
	{
		$path = Yii::app()->getComponent('assetManager')->getBasePath();
		$this->clearDir($path);
	}
	
	private function clearDir($path)
	{
		$files = CFileHelper::findFiles($path);
		foreach($files as $file)
		{
			if(is_dir($file))
			{
				$this-> clearDir($file);
				rmdir($file);
			}
			else
				unlink($file);
		}
	}

	public function down()
	{
		echo "m111005_110452_shop_new_product_structure does not support migration down.\n";
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
