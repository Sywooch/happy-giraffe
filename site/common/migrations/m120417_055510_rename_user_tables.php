<?php

class m120417_055510_rename_user_tables extends CDbMigration
{
	public function up()
	{
        $this->dropTable('user_points_history');
        $this->renameTable('user_social_service', 'user_social_services');
        $this->renameTable('user_partner', 'users_partners');
        $this->renameTable('user_community', 'users_communities');
        $this->renameTable('user_baby', 'users_babies');
        $this->renameTable('user', 'users');
	}

	public function down()
	{
		echo "m120417_055510_rename_user_tables does not support migration down.\n";
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