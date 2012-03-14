<?php

class m120314_112058_change_interest extends CDbMigration
{
	public function up()
	{
        $this->execute('drop table user_interest');
        $this->execute("CREATE TABLE IF NOT EXISTS `interest_users` (
          `user_id` int(10) unsigned NOT NULL,
          `interest_id` int(1) unsigned NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
        $this->execute("ALTER TABLE `interest_users` ADD FOREIGN KEY `interest_users_user` ( `user_id` ) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE ;");
        $this->execute("ALTER TABLE `interest_users` ADD FOREIGN KEY `interest_users_interest` ( `interest_id` ) REFERENCES `interest` (`id`) ON DELETE CASCADE ON UPDATE CASCADE ;");
	}

	public function down()
	{
		echo "m120314_112058_change_interest does not support migration down.\n";
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