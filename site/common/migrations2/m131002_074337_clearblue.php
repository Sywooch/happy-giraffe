<?php

class m131002_074337_clearblue extends CDbMigration
{
	public function up()
	{
        $this->execute("UPDATE `test__tests` SET `start_image` = 'bg_test_pregnancy__clearblue.jpg' WHERE `id` = '3';");
        $this->execute("UPDATE `test__tests` SET `result_image` = 'bg_test_pregnancy_03__flower.jpg' WHERE `id` = '3';");
        $this->execute("UPDATE `test__results` SET `image` = 'bg_test_pregnancy_03__flower.jpg' WHERE `id` = '8';");
        $this->execute("UPDATE `test__results` SET `image` = 'bg_test_pregnancy_03__flower.jpg' WHERE `id` = '9';");
        $this->execute("UPDATE `test__results` SET `image` = 'bg_test_pregnancy_03__flower.jpg' WHERE `id` = '10';");
        $this->execute("UPDATE `test__results` SET `text` = 'Поздравляем! Вероятность того, что вы беременны, очень высока. Чтобы подтвердить радостный факт, воспользуйтесь тестом на беременность Clearblue.' WHERE `id` = '8';");
        $this->execute("UPDATE `test__results` SET `text` = 'Вероятность того, что вы беременны, есть, но она невелика. Возможно, это самое начало беременности или гормональный сбой. Для совершенно точного результата воспользуйтесь тестом на беременность Clearblue.' WHERE `id` = '9';");
        $this->execute("UPDATE `test__results` SET `text` = 'Скорее всего, беременности сейчас нет. Для потверждения результата воспользуйтесь тестом на беременность Clearblue.' WHERE `id` = '10';");
	}

	public function down()
	{
		echo "m131002_074337_clearblue does not support migration down.\n";
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