<?php

class m161213_082220_fix_som_activity extends CDbMigration
{
	public function up()
	{
        $this->execute('INSERT INTO som__activity_type (typeId, title, description) VALUES("answer_pediatrician", "Ответ в сервисе \"Мой педиатр\"", "Добавлен новый ответ")');
	}

	public function down()
	{
		echo "m161213_082220_fix_som_activity does not support migration down.\n";
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