<?php

class m160119_124240_newauth__items_childs_add extends CDbMigration
{
	public function up()
	{
		$sql = <<<'SQL'
INSERT INTO `newauth__items_childs` (`parent`,`child`) VALUES ('createPost','createIdea');
INSERT INTO `newauth__items_childs` (`parent`,`child`) VALUES ('managePost','manageIdea');
INSERT INTO `newauth__items_childs` (`parent`,`child`) VALUES ('manageIdea','updateIdea');
INSERT INTO `newauth__items_childs` (`parent`,`child`) VALUES ('manageIdea','removeIdea');
SQL;
		$this->execute($sql);
	}

	public function down()
	{
		echo "m160119_124240_newauth__items_childs_add does not support migration down.\n";
		return true;
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