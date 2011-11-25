<?php
class m111025_131335_sync extends CDbMigration
{
	public function up()
	{
		$this->execute("ALTER TABLE `club_user_baby` CHANGE `age_group` `age_group` TINYINT( 1 ) NOT NULL ;

CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `text` text NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `author_id` int(11) unsigned NOT NULL,
  `model` varchar(255) NOT NULL,
  `object_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `report` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('Спам','Оскорбление пользователей','Разжигание межнациональной розни','Другое') NOT NULL,
  `text` text NOT NULL,
  `informer_id` int(11) unsigned DEFAULT NULL,
  `model` varchar(255) NOT NULL,
  `object_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `user_via_community` (
  `user_id` int(11) unsigned NOT NULL,
  `community_id` int(11) unsigned NOT NULL,
  KEY `user_id` (`user_id`),
  KEY `community_id` (`community_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;");
		
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
		echo "m111025_131335_sync does not support migration down.\n";
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
