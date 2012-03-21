<?php

class m120316_145013_user_relations extends CDbMigration
{
	public function up()
	{
        $this->execute('
        SET foreign_key_checks = 0;
ALTER TABLE  `user` DROP FOREIGN KEY  `user_country_fk` ;

ALTER TABLE  `user` ADD FOREIGN KEY (  `country_id` ) REFERENCES  `happy_giraffe`.`geo_country` (
`id`
) ON DELETE SET NULL ON UPDATE SET NULL ;

ALTER TABLE  `user` DROP FOREIGN KEY  `user_settlement_fk` ;

ALTER TABLE  `user` ADD FOREIGN KEY (  `settlement_id` ) REFERENCES  `happy_giraffe`.`geo_rus_settlement` (
`id`
) ON DELETE SET NULL ON UPDATE SET NULL ;

ALTER TABLE  `user` DROP FOREIGN KEY  `user_street_fk` ;

ALTER TABLE  `user` ADD FOREIGN KEY (  `street_id` ) REFERENCES  `happy_giraffe`.`geo_rus_street` (
`id`
) ON DELETE SET NULL ON UPDATE SET NULL ;

ALTER TABLE  `user` DROP FOREIGN KEY  `user_ibfk_1` ;

ALTER TABLE  `user` ADD FOREIGN KEY (  `mood_id` ) REFERENCES  `happy_giraffe`.`user_moods` (
`id`
) ON DELETE SET NULL ON UPDATE SET NULL ;
SET foreign_key_checks = 1;
        ');
	}

	public function down()
	{
		echo "m120316_145013_user_relations does not support migration down.\n";
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