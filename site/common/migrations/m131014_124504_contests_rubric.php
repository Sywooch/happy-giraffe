<?php

class m131014_124504_contests_rubric extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `community__contests` ADD CONSTRAINT `Rubric` FOREIGN KEY (`rubric_id`) REFERENCES `community__rubrics` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;");
        $this->execute("ALTER TABLE `community__contests` ADD `status` TINYINT(1)  UNSIGNED  NOT NULL  DEFAULT '0'  AFTER `rubric_id`;");
	}

	public function down()
	{
		echo "m131014_124504_contests_rubric does not support migration down.\n";
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