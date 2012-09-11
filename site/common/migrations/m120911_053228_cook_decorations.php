<?php

class m120911_053228_cook_decorations extends CDbMigration
{
	public function up()
	{
        $this->execute("INSERT INTO  `happy_giraffe`.`auth__items` (
`name` ,
`type` ,
`description` ,
`bizrule` ,
`data`
)");
	}

	public function down()
	{
		echo "m120911_053228_cook_decorations does not support migration down.\n";
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