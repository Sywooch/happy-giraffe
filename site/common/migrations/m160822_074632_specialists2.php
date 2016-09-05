<?php

class m160822_074632_specialists2 extends CDbMigration
{
	public function up()
	{
		$sql = <<<'SQL'
INSERT INTO `newauth__items` (`name`, `type`, `description`, `bizrule`, `data`) VALUES ('specialist', '2', 'Специалист', NULL, NULL);
INSERT INTO `newauth__items` (`name`, `type`, `description`, `bizrule`, `data`) VALUES ('manageOwnSpecialistProfile', 1, 'Управление профилем специалиста', 'return $params[\"entity\"]->id == Yii::app()->user->id;', NULL);
INSERT INTO `newauth__items` (`name`, `type`, `description`, `bizrule`, `data`) VALUES ('editSpecialistProfileData', 0, 'Редактирование данных профиля специалиста', NULL, NULL);
INSERT INTO `newauth__items_childs` (`parent`, `child`) VALUES ('specialist', 'manageOwnSpecialistProfile');
INSERT INTO `newauth__items_childs` (`parent`, `child`) VALUES ('manageOwnSpecialistProfile', 'editSpecialistProfileData');

SQL;

		$this->execute($sql);
	}

	public function down()
	{
		echo "m160822_074632_specialists2 does not support migration down.\n";
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