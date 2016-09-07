<?php

class m140415_105434_section_color extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `community__sections` ADD `color` CHAR(6)  NOT NULL  DEFAULT ''  AFTER `title`;");
        $this->execute("UPDATE `community__sections` SET `color` = '64b2e5' WHERE `id` = '1';");
        $this->execute("UPDATE `community__sections` SET `color` = '73c76a' WHERE `id` = '2';");
        $this->execute("UPDATE `community__sections` SET `color` = 'ff76a1' WHERE `id` = '4';");
        $this->execute("UPDATE `community__sections` SET `color` = 'f26748' WHERE `id` = '3';");
        $this->execute("UPDATE `community__sections` SET `color` = 'a591cd' WHERE `id` = '5';");
        $this->execute("UPDATE `community__sections` SET `color` = 'ffd72c' WHERE `id` = '6';");
	}

	public function down()
	{
		echo "m140415_105434_section_color does not support migration down.\n";
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