<?php

class m120206_125331_create_ratings_table extends CDbMigration
{
	public function up()
	{
        $this->execute("CREATE TABLE IF NOT EXISTS `ratings` (
          `entity_id` int(11) NOT NULL,
          `entity_name` varchar(50) NOT NULL,
          `social_key` varchar(2) NOT NULL,
          `value` mediumint(9) NOT NULL DEFAULT '0',
          PRIMARY KEY (`entity_id`,`entity_name`,`social_key`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;ц");
	}

	public function down()
	{
		echo "m120206_125331_create_ratings_table does not support migration down.\n";
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