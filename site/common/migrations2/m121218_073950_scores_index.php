<?php

class m121218_073950_scores_index extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE  `score__user_scores` ADD INDEX (  `scores` )");
	}

	public function down()
	{
		echo "m121218_073950_scores_index does not support migration down.\n";
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