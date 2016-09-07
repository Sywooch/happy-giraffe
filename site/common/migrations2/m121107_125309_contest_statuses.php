<?php

class m121107_125309_contest_statuses extends CDbMigration
{
	public function up()
	{
        $this->execute("UPDATE  `happy_giraffe`.`contest__contests` SET  `status` =  '3' WHERE  `contest__contests`.`id` =1;");
        $this->execute("UPDATE  `happy_giraffe`.`contest__contests` SET  `status` =  '2' WHERE  `contest__contests`.`id` =2;");
	}

	public function down()
	{
		echo "m121107_125309_contest_statuses does not support migration down.\n";
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