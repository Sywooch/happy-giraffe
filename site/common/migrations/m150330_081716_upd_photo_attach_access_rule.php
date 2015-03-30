<?php

class m150330_081716_upd_photo_attach_access_rule extends CDbMigration
{
	public function up()
	{
        $this->execute('update `newauth__items` set `description` = "Управление фото-аттачами", `bizrule` = "return $params[\"entity\"]->getAuthorId() == \Yii::app()->user->id;" where `name` = "managePhotoAttach";');
	}

	public function down()
	{
		echo "m150330_081716_upd_photo_attach_access_rule does not support migration down.\n";
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