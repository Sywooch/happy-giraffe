<?php

class m120417_083621_rename_contest extends CDbMigration
{
	public function up()
	{
        $this->dropTable('club_contest_user');
        $this->dropTable('club_contest_map');

        $this->renameTable('club_contest','contest__contests');
        $this->renameTable('club_contest_prize','contest__prizes');
        $this->renameTable('club_contest_work','contest__works');
	}

	public function down()
	{
		echo "m120417_083621_rename_contest does not support migration down.\n";
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