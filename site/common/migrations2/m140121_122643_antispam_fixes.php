<?php

class m140121_122643_antispam_fixes extends CDbMigration
{
	public function up()
	{
        $this->execute("TRUNCATE TABLE antispam__check");
        $this->execute("ALTER TABLE `antispam__check` ADD UNIQUE INDEX (`entity`, `entity_id`);");
	}

	public function down()
	{
		echo "m140121_122643_antispam_fixes does not support migration down.\n";
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