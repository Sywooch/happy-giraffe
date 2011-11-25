<?php
class m111013_145926_shop_vaucher_use extends CDbMigration
{
	public function up()
	{
		$this->execute("CREATE TABLE shop_vaucher_use (
	use_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	use_user_id INT(10) UNSIGNED NOT NULL,
	use_vaucher_id INT(10) UNSIGNED NOT NULL,
	use_time INT(10) UNSIGNED NOT NULL,
	PRIMARY KEY (use_id)
)
COLLATE='utf8_general_ci'
ENGINE=MyISAM;");
		
		if(Yii::app()->hasComponent('cache'))
		{
			Yii::app()->getComponent('cache')->flush();
			echo "Cache flused\n";
		}
		
	}
	

	public function down()
	{
		echo "m111013_145926_shop_vaucher_use does not support migration down.\n";
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
