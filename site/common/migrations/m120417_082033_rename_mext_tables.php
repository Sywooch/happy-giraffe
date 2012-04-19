<?php

class m120417_082033_rename_mext_tables extends CDbMigration
{
	public function up()
	{
        $this->renameTable('menstrual_cycle', 'menstrual_cycle__cycles');
        $this->renameTable('menstrual_user_cycle', 'menstrual_cycle__user_cycles');

        $this->renameTable('interest', 'interest__interests');
        $this->renameTable('interest_category', 'interest__categories');
        $this->renameTable('interest_users', 'interest__users_interests');

        $this->renameTable('comment', 'comments');
	}

	public function down()
	{
		echo "m120417_082033_rename_mext_tables does not support migration down.\n";
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