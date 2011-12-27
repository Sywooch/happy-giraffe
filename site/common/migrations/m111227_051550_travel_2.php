<?php

class m111227_051550_travel_2 extends CDbMigration
{
	public function up()
	{
		$this->execute("
INSERT INTO `club_community_content_type` (
`id` ,
`name` ,
`name_plural` ,
`name_accusative` ,
`slug`
)
VALUES (
NULL , 'Путешествие', 'Путешествия', 'Путешествие', 'travel'
);
		");
	}

	public function down()
	{
		echo "m111227_051550_travel_2 does not support migration down.\n";
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