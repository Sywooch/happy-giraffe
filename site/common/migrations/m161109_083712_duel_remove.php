<?php

class m161109_083712_duel_remove extends CDbMigration
{
	public function up()
	{
		$this->execute("SET FOREIGN_KEY_CHECKS=0;");
		$this->execute("DROP TABLE duel__question;");
		$this->execute("DROP TABLE duel__answer;");
		$this->execute("DROP TABLE duel__answer_votes;");
		$this->execute("SET FOREIGN_KEY_CHECKS=1;");
	}

	public function down()
	{
		echo "m161109_083712_duel_remove does not support migration down.\n";
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