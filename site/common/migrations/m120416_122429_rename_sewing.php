<?php

class m120416_122429_rename_sewing extends CDbMigration
{
	public function up()
	{
        $this->renameTable('yarn', 'sewing__yarn_data');
        $this->renameTable('yarn_project', 'sewing__yarn_projects');
	}

	public function down()
	{
		echo "m120416_122429_rename_sewing does not support migration down.\n";
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