<?php

class m120417_093421_rename_bag extends CDbMigration
{
	public function up()
	{
        $this->renameTable('bag_category','bag__categories');
        $this->renameTable('bag_item','bag__items');
        $this->renameTable('bag_offer','bag__offers');
        $this->renameTable('bag_offer_vote','bag__offers_votes');
	}

	public function down()
	{
		echo "m120417_093421_rename_bag does not support migration down.\n";
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