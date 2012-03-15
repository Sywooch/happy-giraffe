<?php

class m120315_170516_fix_user_mood_relation extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE  `user` DROP FOREIGN KEY  `user_ibfk_8` ;

ALTER TABLE  `user` ADD FOREIGN KEY (  `country_id` ) REFERENCES  `happy_giraffe`.`geo_country` (
`id`
) ON DELETE SET NULL ON UPDATE SET NULL ;

ALTER TABLE  `user` DROP FOREIGN KEY  `user_ibfk_9` ;

ALTER TABLE  `user` ADD FOREIGN KEY (  `settlement_id` ) REFERENCES  `happy_giraffe`.`geo_rus_settlement` (
`id`
) ON DELETE SET NULL ON UPDATE SET NULL ;

ALTER TABLE  `user` DROP FOREIGN KEY  `user_ibfk_10` ;

ALTER TABLE  `user` ADD FOREIGN KEY (  `street_id` ) REFERENCES  `happy_giraffe`.`geo_rus_street` (
`id`
) ON DELETE SET NULL ON UPDATE SET NULL ;

ALTER TABLE  `user` DROP FOREIGN KEY  `user_ibfk_2` ;

ALTER TABLE  `user` ADD FOREIGN KEY (  `mood_id` ) REFERENCES  `happy_giraffe`.`user_moods` (
`id`
) ON DELETE SET NULL ON UPDATE SET NULL ;");
	}

	public function down()
	{
		echo "m120315_170516_fix_user_mood_relation does not support migration down.\n";
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