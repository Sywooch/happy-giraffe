<?php

class m120926_054103_index_fix extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE  `user__users_babies` CHANGE  `parent_id`  `parent_id` INT( 11 ) UNSIGNED NOT NULL;

ALTER TABLE  `user__users_babies` ADD INDEX (  `parent_id` );

DELETE b.* FROM user__users_babies b
LEFT OUTER JOIN users u ON b.parent_id = u.id
WHERE u.id IS NULL;

ALTER TABLE  `user__users_babies` ADD FOREIGN KEY (  `parent_id` ) REFERENCES  `happy_giraffe`.`users` (
`id`
) ON DELETE CASCADE ON UPDATE CASCADE ;");
	}

	public function down()
	{
		echo "m120926_054103_index_fix does not support migration down.\n";
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