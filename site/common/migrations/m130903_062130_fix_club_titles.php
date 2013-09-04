<?php

class m130903_062130_fix_club_titles extends CDbMigration
{
	public function up()
	{
        $this->execute("
        UPDATE  `community__sections` SET  `title` = 'Муж и жена' WHERE  `community__sections`.`id` =4;
        UPDATE  `community__sections` SET  `title` = 'Семейный отдых' WHERE  `community__sections`.`id` =6;
        ");
	}

	public function down()
	{
		echo "m130903_062130_fix_club_titles does not support migration down.\n";
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