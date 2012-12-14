<?php

class m121214_055617_communities_primary_key extends CDbMigration
{

	public function up()
	{
        $this->execute('
        ALTER TABLE  `user__users_communities` ADD PRIMARY KEY (  `user_id` ,  `community_id` ) ;
        ALTER TABLE user__users_communities DROP INDEX user_id_2;
        ');
	}

	public function down()
	{
		echo "m121214_055617_communities_primary_key does not support migration down.\n";
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