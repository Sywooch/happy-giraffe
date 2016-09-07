<?php

class m121025_081418_parent_rubrics extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE  `community__rubrics` ADD  `parent_id` INT( 11 ) UNSIGNED NULL");
        $this->execute("ALTER TABLE  `community__rubrics` ADD INDEX (  `parent_id` )");
        $this->execute("ALTER TABLE  `community__rubrics` ADD FOREIGN KEY (  `parent_id` ) REFERENCES  `happy_giraffe`.`community__rubrics` (
`id`
) ON DELETE CASCADE ON UPDATE CASCADE ;");
	}

	public function down()
	{
		echo "m121025_081418_parent_rubrics does not support migration down.\n";
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