<?php

class m160726_132648_alter_commentators_contest_participant extends CDbMigration
{
	public function up()
	{
		$this->createIndex('contest_score_idx', 'commentators__contests_participants', 'contestId, score');

		//$this->dropColumn('commentators__contests_participants', 'place');
	}

	public function down()
	{
		$this->dropIndex('contest_score_idx', 'commentators__contests_participants');

		//$this->addColumn('commentators__contests_participants', 'place', 'smallint NOT NULL');
	}
}