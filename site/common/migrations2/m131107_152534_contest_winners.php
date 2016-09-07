<?php

class m131107_152534_contest_winners extends CDbMigration
{
	public function up()
	{
        $this->execute("DROP TABLE IF EXISTS `community__contest_winners`;

CREATE TABLE `community__contest_winners` (
  `contest_id` int(11) unsigned NOT NULL,
  `work_id` int(11) unsigned NOT NULL,
  `place` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`contest_id`,`work_id`),
  KEY `work_id` (`work_id`),
  CONSTRAINT `community__contest_winners_ibfk_2` FOREIGN KEY (`work_id`) REFERENCES `community__contest_works` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `community__contest_winners_ibfk_1` FOREIGN KEY (`contest_id`) REFERENCES `community__contests` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
	}

	public function down()
	{
		echo "m131107_152534_contest_winners does not support migration down.\n";
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