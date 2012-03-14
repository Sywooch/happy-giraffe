<?php

class m120314_080420_photo_auth_items extends CDbMigration
{

	public function up()
	{
        $this->execute("INSERT INTO  `happy_giraffe`.`auth_item` (
`name` ,
`type` ,
`description` ,
`bizrule` ,
`data`
)
VALUES (
'removeAlbum',  '0',  'Удаление альбомов пользователей', NULL , NULL);");
        $this->execute("INSERT INTO  `happy_giraffe`.`auth_item_child` (
`parent` ,
`child`
)
VALUES (
'isAuthor',  'removeAlbum'
);
");
	}

	public function down()
	{
		echo "m120314_080420_photo_auth_items does not support migration down.\n";
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