<?php

class m120514_121128_add_test_descriptions extends CDbMigration
{
    private $_table = 'test__tests';
	public function up()
	{
        $this->addColumn($this->_table, 'meta_description', 'varchar(1024)');
        $this->update($this->_table, array(
            'meta_description'=>'Познакомьтесь с нашим новым сервисом: Волосы: определение типа. Пройдите интересное тестирование и узнайте, к какому типу относятся ваши волосы, а также получите ценные рекомендации по уходу за ними'
        ), 'id=1');
        $this->update($this->_table, array(
            'meta_description'=>'Введение прикорма – очень ответственный этап в жизни каждого младенца. Тут нельзя торопиться, но и откладывать не стоит. Когда же ваш ребенок будет точно готов получить первый прикорм? Узнайте, пройдя небольшой тест нашего сервиса'
        ), 'id=2');
        $this->update($this->_table, array(
            'meta_description'=>'Наш тест онлайн на беременность – прекрасная возможность подтвердить или опровергнуть свои опасения. Ответьте честно на вопросы нашего теста и убедитесь в этом сами! Важно: сервис является совершенно бесплатным'
        ), 'id=3');
        $this->update($this->_table, array(
            'meta_description'=>'Пупок новорожденного – это его самое уязвимое место, практически открытая рана. Поэтому многие мамы начинают беспокоиться, всё ли в порядке с пупком у их малыша. Пройдите простой тест и будьте уверены в своих действиях'
        ), 'id=4');
	}

	public function down()
	{
		$this->dropColumn($this->_table,'meta_description');
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