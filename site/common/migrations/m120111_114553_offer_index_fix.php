<?php

class m120111_114553_offer_index_fix extends CDbMigration
{
    private $_table = 'bag_offer_vote';

	public function up()
	{
        $this->dropTable($this->_table);

        $this->execute('CREATE TABLE IF NOT EXISTS `bag_offer_vote` (
  `user_id` int(11) unsigned NOT NULL,
  `vote` tinyint(1) NOT NULL,
  `object_id` int(10) unsigned NOT NULL,
  KEY `bag_user_vote_user_fk` (`user_id`),
  KEY `bag_user_vote_object_fk` (`object_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `bag_offer_vote`
  ADD CONSTRAINT `bag_user_vote_object_fk` FOREIGN KEY (`object_id`) REFERENCES `bag_offer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bag_user_vote_user_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
');
	}

	public function down()
	{

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