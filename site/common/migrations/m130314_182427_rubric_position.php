<?php

class m130314_182427_rubric_position extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE  `community__rubrics` ADD  `sort` SMALLINT( 5 ) UNSIGNED NOT NULL");
	}

	public function down()
	{
		echo "m130314_182427_rubric_position does not support migration down.\n";
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