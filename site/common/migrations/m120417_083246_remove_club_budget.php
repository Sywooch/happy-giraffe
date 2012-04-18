<?php

class m120417_083246_remove_club_budget extends CDbMigration
{
	public function up()
	{
        $this->dropTable('club_budget');
        $this->dropTable('club_budget_theme');
	}

	public function down()
	{
		echo "m120417_083246_remove_club_budget does not support migration down.\n";
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