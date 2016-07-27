<?php

class m160719_143850_alter_rating_history extends CDbMigration
{
	public function up()
	{
		$this->execute("ALTER TABLE `qa__rating_history`
ADD COLUMN `id`  int UNSIGNED NOT NULL AUTO_INCREMENT FIRST ,
ADD PRIMARY KEY (`id`);");
	}

	public function down()
	{
		return true;
	}
}