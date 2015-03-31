<?php

class m150331_074326_consultations4 extends CDbMigration
{
	public function up()
	{
		$sql = <<<SQL
UPDATE `newauth__items_childs` SET `parent` = 'moderator' WHERE `parent` = 'manageConsultation' AND `child` = 'removeQuestions';

SQL;
		$this->execute($sql);
	}

	public function down()
	{
		echo "m150331_074326_consultations4 does not support migration down.\n";
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