<?php

class m121115_094417_contest_work_removed extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE  `contest__works` ADD  `removed` TINYINT( 1 ) UNSIGNED NOT NULL");
        $this->execute("INSERT INTO  `happy_giraffe`.`auth__items` (
`name` ,
`type` ,
`description` ,
`bizrule` ,
`data`
)
VALUES (
'removeContestWork',  '0',  'Удаление конкурсных работ', NULL , NULL
);");
	}

	public function down()
	{
		echo "m121115_094417_contest_work_removed does not support migration down.\n";
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