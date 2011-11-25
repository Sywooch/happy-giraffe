<?php
class m111013_131041_shop_vaucher extends CDbMigration
{
	public function up()
	{
		$this->execute("CREATE TABLE shop_vaucher (
	vaucher_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	vaucher_code VARCHAR(50) NOT NULL,
	vaucher_discount DECIMAL(10,2) UNSIGNED NOT NULL,
	vaucher_time INT(10) UNSIGNED NOT NULL,
	vaucher_from_time INT(10) UNSIGNED NOT NULL,
	vaucher_till_time INT(10) UNSIGNED NOT NULL,
	vaucher_text TEXT NULL,
	PRIMARY KEY (vaucher_id),
	UNIQUE INDEX vaucher_code (vaucher_code)
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
		echo "m111013_131041_shop_vaucher does not support migration down.\n";
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
