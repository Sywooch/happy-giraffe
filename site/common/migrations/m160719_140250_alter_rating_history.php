<?php

class m160719_140250_alter_rating_history extends CDbMigration
{
	public function up()
	{
		$this->alterColumn('qa__rating_history', 'created_at', 'int NOT NULL');
	}

	public function down()
	{
		$this->alterColumn('qa__rating_history', 'created_at', 'timestamp');
	}
}