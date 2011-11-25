<?php
class m111102_104935_shop_order_adress extends CDbMigration
{
	public function up()
	{
		$this->execute("CREATE TABLE `shop_order_adress` (
	`adress_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`adress_order_id` INT(10) UNSIGNED NOT NULL,
	`adress_index` VARCHAR(32) NOT NULL,
	`adress_region_id` INT(10) UNSIGNED NOT NULL,
	`adress_city_id` INT(10) UNSIGNED NOT NULL,
	`adress_street` VARCHAR(250) NOT NULL,
	`adress_house` VARCHAR(32) NOT NULL,
	`adress_corps` VARCHAR(32) NOT NULL,
	`adress_room` VARCHAR(32) NULL DEFAULT NULL,
	`adress_porch` VARCHAR(32) NULL DEFAULT NULL,
	`adress_floor` VARCHAR(32) NULL DEFAULT NULL,
	PRIMARY KEY (`adress_id`),
	INDEX `adress_order_id` (`adress_order_id`)
)
COLLATE='utf8_general_ci'
ENGINE=MyISAM
AUTO_INCREMENT=11;");
		
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
		echo "m111102_104935_shop_order_adress does not support migration down.\n";
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
