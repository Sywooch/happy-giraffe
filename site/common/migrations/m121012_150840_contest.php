<?php

class m121012_150840_contest extends CDbMigration
{
	public function up()
	{
        $this->execute("INSERT INTO  `contest__contests` (
`id` ,
`title` ,
`text` ,
`image` ,
`from_time` ,
`till_time` ,
`status` ,
`time` ,
`user_id` ,
`stop_reason`
)
VALUES (
NULL ,  'Мама и я', NULL , NULL ,  '2012-10-15',  '2012-11-05', NULL , NULL , NULL , NULL");
	}

	public function down()
	{
		echo "m121012_150840_contest does not support migration down.\n";
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