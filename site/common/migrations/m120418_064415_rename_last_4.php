<?php

class m120418_064415_rename_last_4 extends CDbMigration
{
	public function up()
	{
        $this->renameTable('user_scores','score__user_scores');
        $this->renameTable('user_cache','im__user_cache');
        $this->renameTable('user_address','geo__user_address');

        $this->renameTable('users_babies','user__users_babies');
        $this->renameTable('users_communities','user__users_communities');
        $this->renameTable('users_partners','user__users_partners');
        $this->renameTable('user_moods','user__moods');
        $this->renameTable('user_purposes','user__purposes');
        $this->renameTable('user_social_services','user__social_services');
        $this->renameTable('user_statuses','user__statuses');
	}

	public function down()
	{
		echo "m120418_064415_rename_last_4 does not support migration down.\n";
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