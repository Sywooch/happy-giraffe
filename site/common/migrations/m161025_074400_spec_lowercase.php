<?php

class m161025_074400_spec_lowercase extends CDbMigration
{
	public function up()
	{
		$this->execute("UPDATE specialists__specializations
SET title = REPLACE(REPLACE(title, 'Детский', 'детский'), 'Педиатр', 'педиатр');");
		$this->execute("UPDATE users u
JOIN specialists__profiles p ON p.id = u.id
SET specialistInfo = CONCAT('{\"title\":\"', (SELECT GROUP_CONCAT(s.title SEPARATOR ', ')
FROM specialists__profiles_specializations ps
JOIN specialists__specializations s ON ps.specializationId = s.id
WHERE ps.profileId = p.id), '\"}');");
	}

	public function down()
	{
		echo "m161025_074400_spec_lowercase does not support migration down.\n";
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