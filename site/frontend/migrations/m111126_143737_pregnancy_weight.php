<?php
class m111126_143737_pregnancy_weight extends CDbMigration
{
	public function up()
	{
		$this->execute("CREATE TABLE IF NOT EXISTS `pregnancy_weight` (
  `week` int(11) NOT NULL,
  `w1` varchar(8) NOT NULL,
  `w2` varchar(8) NOT NULL,
  `w3` varchar(8) NOT NULL,
  PRIMARY KEY (`week`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `pregnancy_weight` (`week`, `w1`, `w2`, `w3`) VALUES
(6, '1.4', '1.0', '0.6'),
(2, '0.5', '0.5', '0.5'),
(4, '0.9', '0.7', '0.5'),
(8, '1.6', '1.2', '0.7'),
(10, '1.8', '1.3', '0.8'),
(12, '2', '1.5', '0.9'),
(14, '2.7', '1.9', '1'),
(16, '3.2', '2.3', '1.4'),
(18, '4.5', '3.6', '2.3'),
(20, '5.4', '4.8', '2.9'),
(22, '6.8', '5.7', '3.4'),
(24, '7.7', '6.4', '3.9'),
(26, '8.6', '7.7', '5.0'),
(28, '9.8', '8.2', '5.4'),
(30, '10.2', '9.1', '5.9'),
(32, '11.3', '10.0', '6.4'),
(34, '12.5', '10.9', '7.3'),
(36, '13.6', '11.8', '7.9'),
(38, '14.5', '12.7', '8.6'),
(40, '15.2', '13.6', '9.1');
");
		
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
		echo "m111126_143737_pregnancy_weight does not support migration down.\n";
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
