<?php

class m160908_141504_change_column_type extends CDbMigration
{
	public function up()
	{
	    $this->execute("ALTER TABLE `post__contents` CHANGE originEntityId originEntityId integer(11) NOT NULL;");
	}

	public function down()
	{
		$this->execute("ALTER TABLE `post__contents` CHANGE originEntityId originEntityId varchar(100) NOT NULL;");
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