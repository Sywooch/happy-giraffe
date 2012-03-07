<?php

class m120306_164640_user_community extends CDbMigration
{
	public function up()
	{
        $this->execute("RENAME TABLE `happy_giraffe`.`user_via_community` TO `happy_giraffe`.`user_community` ;");
        $this->execute("ALTER TABLE `user_community` ADD UNIQUE (
`user_id` ,
`community_id`
);
");
	}

	public function down()
	{
		echo "m120306_164640_user_community does not support migration down.\n";
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