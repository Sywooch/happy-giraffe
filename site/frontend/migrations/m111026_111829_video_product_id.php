<?php
class m111026_111829_video_product_id extends CDbMigration
{
	public function up()
	{
		$this->execute("ALTER TABLE `shop_product_video` ADD `product_id` INT( 11 ) UNSIGNED NOT NULL ;");
		
		if(Yii::app()->hasComponent('cache'))
		{
			Yii::app()->getComponent('cache')->flush();
			echo "Cache flused\n";
		}
		
		$this->clearAssets();
	}
	
	private function clearAssets()
	{
		$path = Yii::app()->getComponent('assetManager')->getBasePath();
		$this->clearDir($path);
		echo "Assets clear\n";
	}

	private function clearDir($folder, $main=true)
	{
		if(is_dir($folder))
		{
			$handle = opendir($folder);
			while($subfile = readdir($handle))
			{
				if($subfile == '.' || $subfile == '..')
					continue;
				if(is_file($subfile))
					unlink("{$folder}/{$subfile}");
				else
					$this->clearDir("{$folder}/{$subfile}", false);
			}
			closedir($handle);
			if(!$main)
				rmdir($folder);
		}
		else
			unlink($folder);
	}

	public function down()
	{
		echo "m111026_111829_video_product_id does not support migration down.\n";
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
