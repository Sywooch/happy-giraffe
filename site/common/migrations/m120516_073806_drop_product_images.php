<?php

class m120516_073806_drop_product_images extends CDbMigration
{
	public function up()
	{
        $this->execute("DROP TABLE `shop__product_image`");
	}

	public function down()
	{
		echo "m120516_073806_drop_product_images does not support migration down.\n";
		return false;
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