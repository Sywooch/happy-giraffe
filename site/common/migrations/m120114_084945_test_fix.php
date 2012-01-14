<?php

class m120114_084945_test_fix extends CDbMigration
{
	public function up()
	{
        $this->execute("UPDATE  `happy_giraffe`.`test_result` SET  `text` =  '<p>Нет, ваш малыш ещё не готов к введению прикорма. Начинать знакомить его с новыми продуктами на сегодняшний день рано.</p>
<p>Не волнуйтесь! Всё необходимое ребенок получает из молока матери или адаптированной смеси, поэтому на его состоянии здоровья это никак не отразится.</p>
<p>Попробуйте воспользоваться нашим сервисом ещё раз через неделю: ребёнок подрастёт, и, возможно, результат будет другим.</p>' WHERE  `test_result`.`id` =6 LIMIT 1 ;");
	}

	public function down()
	{

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