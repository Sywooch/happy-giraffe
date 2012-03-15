<?php

class m120315_173013_update_comments_positions extends CDbMigration
{
	public function up()
	{
        Yii::import('site.common.models.*');
        Comment::updateComments();
	}

	public function down()
	{
		echo "m120229_095352_update_comments_positions does not support migration down.\n";
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