<?php

class m120417_125204_rename_last_columns_2 extends CDbMigration
{
	public function up()
	{
        $this->renameColumn('score__levels','name','title');

        $this->renameColumn('test__questions','name','title');
        $this->renameColumn('test__results','name','title');
        $this->renameColumn('test__tests','name','title');

        $this->renameColumn('user_moods','name','title');
	}

	public function down()
	{
		echo "m120417_125204_rename_last_columns_2 does not support migration down.\n";
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