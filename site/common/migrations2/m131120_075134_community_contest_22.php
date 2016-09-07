<?php

class m131120_075134_community_contest_22 extends CDbMigration
{
	public function up()
	{
        $this->execute("INSERT INTO `community__rubrics` (`id`, `title`, `community_id`, `user_id`, `parent_id`, `sort`) VALUES (NULL, 'Дорогой, я беременна', '2', NULL, NULL, '0');");
        $this->execute("INSERT INTO `community__contests` (`id`, `title`, `description`, `rules`, `forum_id`, `rubric_id`, `status`) VALUES (NULL, 'Как вы рассказали своему мужу о беременности', 'Возможно, вы организовали вкусный ужин и как-то необычно сообщили об этом волшебном событии, может быть преподнесли тест с двумя полосочками, красиво упакованный, или написали прикольную смску, может... Обязательно напишите как на это отреагировал муж? Какая у него была реакция?', '', '2', :rubricId, '0');", array(':rubricId' => Yii::app()->db->getLastInsertID()));
        $this->execute("UPDATE `community__contests` SET `cssClass` = 'pets1' WHERE `id` = '1';");
        $this->execute("UPDATE `community__contests` SET `cssClass` = 'birth2' WHERE `id` = '2';");
        $this->execute("UPDATE `community__contests` SET `textHint` = 'Расскажите о своём домашнем животном ( как его зовут, какой он породы, как вы за ним ухаживаете? что он умеет делать, какие лакомства он любит и т.д?)' WHERE `id` = '1';");
        $this->execute("UPDATE `community__contests` SET `textHint` = 'Расскажите как это было, как это случилось у вас. Как ваш муж отреагировал? Необходимо сопроводить свой рассказ семейной фотографией, на которой есть мама, папа и ребенок.' WHERE `id` = '2';");
	}

	public function down()
	{
		echo "m131120_075134_community_contest_22 does not support migration down.\n";
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