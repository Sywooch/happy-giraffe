<?php

class m130911_054029_family_remove extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `user__users_babies` ADD `removed` TINYINT(1)  UNSIGNED  NOT NULL;");
        $this->execute("ALTER TABLE `user__users_partners` ADD `removed` TINYINT(1)  UNSIGNED  NOT NULL;");
	}

	public function down()
	{
		echo "m130911_054029_family_remove does not support migration down.\n";
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