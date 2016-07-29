<?php

class m160726_132623_alter_commentators_contest extends CDbMigration
{
	public function up()
	{
		$this->dropColumn('commentators__contests', 'startDate');
		$this->dropColumn('commentators__contests', 'endDate');

		$this->addColumn('commentators__contests', 'month', 'string NOT NULL');

		$this->createIndex('month_idx', 'commentators__contests', 'month');

		$this->renameColumn('commentators__contests', 'title', 'name');
	}

	public function down()
	{
		$this->addColumn('commentators__contests', 'startDate', 'timestamp');
		$this->addColumn('commentators__contests', 'endDate', 'timestamp');

		$this->dropIndex('month_idx', 'commentators__contests');

		$this->dropColumn('commentators__contests', 'month');

		$this->renameColumn('commentators__contests', 'name', 'title');
	}
}