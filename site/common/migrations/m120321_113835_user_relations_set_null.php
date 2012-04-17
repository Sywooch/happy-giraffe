<?php

class m120321_113835_user_relations_set_null extends CDbMigration
{
	public function up()
	{
        $this->execute('
        SET foreign_key_checks = 0;
ALTER TABLE  `user` DROP FOREIGN KEY user_country_fk;
ALTER TABLE  `user` ADD  FOREIGN KEY user_country_fk (  `country_id` ) REFERENCES  `geo_country` (`id`) ON DELETE SET NULL ON UPDATE SET NULL ;

ALTER TABLE  `user` DROP FOREIGN KEY user_settlement_fk;
ALTER TABLE  `user` ADD  FOREIGN KEY user_settlement_fk  ( `settlement_id` ) REFERENCES  `geo_rus_settlement` (`id`) ON DELETE SET NULL ON UPDATE SET NULL ;

ALTER TABLE  `user` DROP FOREIGN KEY user_street_fk;
ALTER TABLE  `user` ADD  FOREIGN KEY user_street_fk (  `street_id` ) REFERENCES  `geo_rus_street` (`id`) ON DELETE SET NULL ON UPDATE SET NULL ;

ALTER TABLE  `user` DROP FOREIGN KEY mood_id;
ALTER TABLE  `user` ADD  FOREIGN KEY mood_id (`mood_id`) REFERENCES `user_moods` (`id`) ON DELETE SET NULL ON UPDATE SET NULL ;

SET foreign_key_checks = 1;
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