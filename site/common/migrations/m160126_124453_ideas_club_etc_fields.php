<?php

class m160126_124453_ideas_club_etc_fields extends CDbMigration
{
	public function up()
	{
		$sql = <<<'SQL'
ALTER TABLE `som__idea`
ADD COLUMN `club`  int(10) UNSIGNED NOT NULL AFTER `labels`,
ADD COLUMN `forums`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL AFTER `club`,
ADD COLUMN `rubrics`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL AFTER `forums`;
SQL;

		$this->execute($sql);

	}

	public function down()
	{
		echo "m160126_124453_ideas_club_etc_fields does not support migration down.\n";
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