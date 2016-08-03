<?php

class m160726_132658_alter_commentators_contest_comments extends CDbMigration
{
	public function up()
	{
		$this->renameColumn('commentators__contests_comments', 'counts', 'points');
	}

	public function down()
	{
		$this->renameColumn('commentators__contests_comments', 'points', 'counts');
	}
}