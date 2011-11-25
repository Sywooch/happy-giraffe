<?php
class m111012_123800_shop_category_title extends CDbMigration
{
	public function up()
	{
		$this->execute("ALTER TABLE shop_category
	ADD COLUMN category_title VARCHAR(150) NOT NULL AFTER category_name;
");
		
		if(Yii::app()->hasComponent('cache'))
		{
			Yii::app()->getComponent('cache')->flush();
			echo "Cache flused\n";
		}
		
	}
	

	public function down()
	{
		echo "m111012_123800_shop_category_title does not support migration down.\n";
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
