<?php
class m111025_152510_age_range_data extends CDbMigration
{
	public function up()
	{
		$this->execute("REPLACE INTO `age_range` (`range_id`, `range_title`, `range_order`)
VALUES (1, '0 - 12 мес.', 0),
(2, '1 - 2 года', 1),
(3, '2 - 3 года', 2),
(4, '3 - 5 лет', 3),
(5, '5 - 7 лет', 4),
(6, '7 -11 лет', 5),
(7, '11 - 14 лет', 6),
(8, 'старше 14 лет', 7);");
		
		
	}
	

	public function down()
	{
		echo "m111025_152510_age_range_data does not support migration down.\n";
		return false;
		
		$this->execute("");
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
