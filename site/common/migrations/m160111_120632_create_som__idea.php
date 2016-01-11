<?php

class m160111_120632_create_som__idea extends CDbMigration
{
	public function up()
	{
		$this->execute("CREATE TABLE `som__idea` (
`id`  int(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
`title`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`collectionId`  int(10) UNSIGNED NOT NULL ,
`authorId`  int(10) UNSIGNED NOT NULL ,
`isDraft`  tinyint(1) UNSIGNED NOT NULL DEFAULT 0 ,
`isRemoved`  tinyint(1) UNSIGNED NOT NULL DEFAULT 0 ,
`dtimeCreate`  int(10) UNSIGNED NOT NULL ,
`labels`  text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`forumId`  int(10) NULL DEFAULT NULL ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
ROW_FORMAT=COMPACT
;");
	}

	public function down()
	{
		$this->dropTable("som__idea");
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