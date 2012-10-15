<?php

class m121015_092552_works_index extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE  `contest__works` ADD INDEX (  `created` )");
        $this->execute("ALTER TABLE  `contest__works` ADD INDEX (  `rate` )");
	}

	public function down()
	{
		echo "m121015_092552_works_index does not support migration down.\n";
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