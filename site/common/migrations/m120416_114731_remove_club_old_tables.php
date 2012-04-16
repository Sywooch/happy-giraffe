<?php

class m120416_114731_remove_club_old_tables extends CDbMigration
{
    public function up()
    {
        $this->dropTable('club_photo');
        $this->dropTable('club_post');
        $this->dropTable('club_theme');
    }

	public function down()
	{
		echo "m120416_114731_remove_club_old_tables does not support migration down.\n";
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