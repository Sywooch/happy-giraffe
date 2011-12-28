<?php

class m111228_122725_purposes extends CDbMigration
{
	public function up()
	{
		$this->execute("INSERT INTO `happy_giraffe`.`recipeBook_purpose` (`id`, `name`) VALUES (NULL, 'Ванны'), (NULL, 'Компрессы'), (NULL, 'Мази'), (NULL, 'Настои'), (NULL, 'Настойки'), (NULL, 'Отвары'), (NULL, 'Припарки'), (NULL, 'Растворы'), (NULL, 'Растирки'), (NULL, 'Смеси');");
	}

	public function down()
	{
		echo "m111228_122725_purposes does not support migration down.\n";
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