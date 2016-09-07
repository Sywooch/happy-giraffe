<?php

class m130528_123325_messages_relations extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `messaging__messages` ADD CONSTRAINT `Author` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;");
        $this->execute("ALTER TABLE `messaging__messages` ADD CONSTRAINT `Thread` FOREIGN KEY (`thread_id`) REFERENCES `messaging__threads` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;");
	}

	public function down()
	{
		echo "m130528_123325_messages_relations does not support migration down.\n";
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