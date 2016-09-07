<?php

class m120522_132104_manageActivity extends CDbMigration
{
	public function up()
	{
        $this->execute("INSERT INTO `auth__items` (
`name` ,
`type` ,
`description` ,
`bizrule` ,
`data`
)
VALUES (
'manageActivity', '0', 'Управление страницей активности', NULL , NULL
);");
	}

	public function down()
	{
		echo "m120522_132104_manageActivity does not support migration down.\n";
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