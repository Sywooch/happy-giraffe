<?php

class m161020_084709_specs_titles_update extends CDbMigration
{
	public function up()
	{
		$this->execute("UPDATE users u
JOIN specialists__profiles p ON p.id = u.id
SET specialistInfo = CONCAT('{\"title\":\"', (SELECT GROUP_CONCAT(s.title SEPARATOR ', ')
FROM specialists__profiles_specializations ps
JOIN specialists__specializations s ON ps.specializationId = s.id
WHERE ps.profileId = p.id), '\"}');");
	}

	public function down()
	{
		echo "m161020_084709_specs_titles_update does not support migration down.\n";
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