<?php

class m130312_173645_im_index extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE  `im__messages` ADD INDEX (  `created` )");
	}

	public function down()
	{
		echo "m130312_173645_im_index does not support migration down.\n";
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