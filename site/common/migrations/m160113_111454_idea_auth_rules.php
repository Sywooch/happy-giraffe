<?php

class m160113_111454_idea_auth_rules extends CDbMigration
{
	public function up()
	{
		$sql = <<<'SQL'
INSERT INTO `newauth__items` (`name`,`type`,`description`,`bizrule`,`data`) VALUES ('manageIdea',1,'���������� �����',NULL,NULL);
INSERT INTO `newauth__items` (`name`,`type`,`description`,`bizrule`,`data`) VALUES ('createIdea',1,'���������� ����',NULL,NULL);
INSERT INTO `newauth__items` (`name`,`type`,`description`,`bizrule`,`data`) VALUES ('updateIdea',0,'�������������� ����',NULL,NULL);
INSERT INTO `newauth__items` (`name`,`type`,`description`,`bizrule`,`data`) VALUES ('removeIdea',0,'�������� ����',NULL,NULL);
SQL;

		$this->execute($sql);
	}

	public function down()
	{
		echo "m160113_111454_idea_auth_rules does not support migration down.\n";
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