<?php

class m150330_151809_consultations3 extends CDbMigration
{
	public function up()
	{
		$sql = <<<SQL
ALTER TABLE `consultation__questions` ADD `removed` TINYINT(1)  NOT NULL;
INSERT INTO `newauth__items` (`name`, `type`, `description`, `bizrule`, `data`) VALUES ('removeQuestions', '0', 'Удаление вопросов', NULL, NULL);
INSERT INTO `newauth__items_childs` (`parent`, `child`) VALUES ('manageConsultation', 'removeQuestions');
SQL;
		$this->execute($sql);
	}

	public function down()
	{
		echo "m150330_151809_consultations3 does not support migration down.\n";
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