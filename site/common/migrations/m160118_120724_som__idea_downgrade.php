<?php

class m160118_120724_som__idea_downgrade extends CDbMigration
{
	public function up()
	{
		$this->execute("ALTER TABLE `som__idea`
DROP COLUMN `isDraft`,
DROP COLUMN `forumId`;");
	}

	public function down()
	{
		echo "m160118_120724_som__idea_downgrade does not support migration down.\n";
		return true;
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