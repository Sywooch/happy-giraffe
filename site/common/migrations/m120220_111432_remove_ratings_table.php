<?php

class m120220_111432_remove_ratings_table extends CDbMigration
{
	public function up()
	{
        $this->dropTable('ratings_yohoho');
        $this->dropTable('ratings');
	}

	public function down()
	{
		echo "m120220_111432_remove_ratings_table does not support migration down.\n";
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