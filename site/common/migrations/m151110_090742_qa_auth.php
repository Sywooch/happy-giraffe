<?php

class m151110_090742_qa_auth extends CDbMigration
{
	public function up()
	{
		$sql = <<<'SQL'
INSERT INTO `newauth__items` (`name`, `type`, `description`, `bizrule`, `data`) VALUES ('createQaQuestion', '0', 'Добавление вопроса', 'return $params[\"question\"]->canBeAnsweredBy(\\Yii::app()->user->id);', NULL);
SQL;

		$this->execute($sql);
		$this->execute("INSERT INTO `newauth__items` (`name`, `type`, `description`, `bizrule`, `data`) VALUES ('manageQaQuestion', '1', 'Управление вопросом', NULL, NULL);");
		$this->execute("INSERT INTO `newauth__items` (`name`, `type`, `description`, `bizrule`, `data`) VALUES ('updateQaQuestion', '0', 'Редактирование вопроса', NULL, NULL);");
		$this->execute("INSERT INTO `newauth__items` (`name`, `type`, `description`, `bizrule`, `data`) VALUES ('removeQaQuestion', '0', 'Удаление вопроса', NULL, NULL);");
		$this->execute("INSERT INTO `newauth__items` (`name`, `type`, `description`, `bizrule`, `data`) VALUES ('restoreQaQuestion', '0', 'Восстановление вопроса', NULL, NULL);");
		$this->execute("INSERT INTO `newauth__items_childs` (`parent`, `child`) VALUES ('user', 'createQaQuestion');");
		$this->execute("INSERT INTO `newauth__items_childs` (`parent`, `child`) VALUES ('manageQaQuestion', 'updateQaQuestion');");
		$this->execute("INSERT INTO `newauth__items_childs` (`parent`, `child`) VALUES ('manageQaQuestion', 'removeQaQuestion');");
		$this->execute("INSERT INTO `newauth__items_childs` (`parent`, `child`) VALUES ('manageQaQuestion', 'restoreQaQuestion');");
		$this->execute("INSERT INTO `newauth__items_childs` (`parent`, `child`) VALUES ('moderator', 'manageQaQuestion');");
		$this->execute("INSERT INTO `newauth__items_childs` (`parent`, `child`) VALUES ('manageOwnContent', 'manageQaQuestion');");
	}

	public function down()
	{
		echo "m151110_090742_qa_auth does not support migration down.\n";
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