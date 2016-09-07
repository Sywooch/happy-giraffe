<?php

class m150423_080645_myGiraffe extends CDbMigration
{
	public function up()
	{
		$sql = <<<SQL
CREATE TABLE `myGiraffe__feed_items` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(11) unsigned NOT NULL,
  `filter` varchar(20) NOT NULL DEFAULT '',
  `postId` int(11) unsigned NOT NULL,
  `dtimeCreate` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUE` (`userId`,`filter`,`postId`),
  KEY `dtimeCreate` (`dtimeCreate`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SQL;
		$this->execute($sql);
	}

	public function down()
	{
		echo "m150423_080645_myGiraffe does not support migration down.\n";
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