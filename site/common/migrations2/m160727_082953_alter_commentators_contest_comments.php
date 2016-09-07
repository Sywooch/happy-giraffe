<?php

class m160727_082953_alter_commentators_contest_comments extends CDbMigration
{
	public function up()
	{
		$this->alterColumn('commentators__contests_comments', 'points', 'int');
	}

	public function down()
	{
		$this->alterColumn('commentators__contests_comments', 'points', 'tinyint');
	}
}