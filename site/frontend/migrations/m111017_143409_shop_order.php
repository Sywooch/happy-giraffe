<?php
class m111017_143409_shop_order extends CDbMigration
{
	public function up()
	{
		$this->execute("CREATE TABLE shop_order (
	order_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	order_status INT(10) NOT NULL DEFAULT '1',
	order_time INT(10) UNSIGNED NOT NULL,
	order_user_id INT(10) UNSIGNED NOT NULL,
	order_item_count INT(10) UNSIGNED NOT NULL,
	order_price DECIMAL(12,2) UNSIGNED NOT NULL,
	order_price_total DECIMAL(12,2) UNSIGNED NOT NULL,
	order_width DECIMAL(12,2) UNSIGNED NOT NULL,
	order_volume DECIMAL(12,2) UNSIGNED NOT NULL,
	order_description TEXT NULL,
	order_vaucher_id INT(10) UNSIGNED NULL DEFAULT NULL,
	PRIMARY KEY (order_id),
	INDEX order_user_id (order_user_id)
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
		echo "m111017_143409_shop_order does not support migration down.\n";
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
