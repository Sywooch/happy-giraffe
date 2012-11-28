<?php

class m121127_111212_activity extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE  `community__contents` ADD  `last_updated` TIMESTAMP NULL AFTER  `created`");
        $this->execute("ALTER TABLE  `contest__contests` ADD  `last_updated` TIMESTAMP NULL");
        $this->execute("ALTER TABLE  `cook__recipes` ADD  `last_updated` TIMESTAMP NULL AFTER  `created`");

        $this->execute("ALTER TABLE  `community__contents` ADD INDEX (  `last_updated` )");
        $this->execute("ALTER TABLE  `contest__contests` ADD INDEX (  `last_updated` )");
        $this->execute("ALTER TABLE  `cook__recipes` ADD INDEX (  `last_updated` )");

	}

	public function down()
	{
		echo "m121127_111212_activity does not support migration down.\n";
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