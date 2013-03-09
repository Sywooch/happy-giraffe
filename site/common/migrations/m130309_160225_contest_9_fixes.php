<?php

class m130309_160225_contest_9_fixes extends CDbMigration
{
	public function up()
	{
        $sql = <<<EOD
UPDATE `contest__contests` SET `text` = '<p>Для каждой мамы ее малыш самый лучший и уникальный. А моменты первых успехов ребенка – самые волнительные и запоминающиеся! Конечно, их нужно обязательно запечатлеть, чтобы сохранить в памяти эти драгоценные моменты. </p>
EOD;
        $this->execute($sql);

        $this->execute("UPDATE  `contest__contests` SET  `till_time` =  '2013-03-22' WHERE  `contest__contests`.`id` =9;");
	}

	public function down()
	{
		echo "m130309_160225_contest_9_fixes does not support migration down.\n";
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