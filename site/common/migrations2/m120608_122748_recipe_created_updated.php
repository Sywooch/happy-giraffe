<?php

class m120608_122748_recipe_created_updated extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `cook__recipes` ADD `updated` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NULL ,
ADD `created` TIMESTAMP NOT NULL ");
        $this->execute("update cook__cuisines set title = left(title, char_length(title) - 6);");
	}

	public function down()
	{
		echo "m120608_122748_recipe_created_updated does not support migration down.\n";
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