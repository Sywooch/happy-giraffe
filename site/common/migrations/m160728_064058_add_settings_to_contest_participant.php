<?php

class m160728_064058_add_settings_to_contest_participant extends CDbMigration
{
	public function up()
	{
		$this->addColumn('commentators__contests_participants', 'settings', 'text');
	}

	public function down()
	{
		$this->dropColumn('commentators__contests_participants', 'settings');
	}
}