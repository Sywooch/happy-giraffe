<?php

class m130909_100703_hide_some_srvices extends CDbMigration
{
	public function up()
	{
        $this->execute("
        UPDATE  `happy_giraffe`.`services` SET  `show` =  '0' WHERE  `services`.`id` =2;
        UPDATE  `happy_giraffe`.`services` SET  `show` =  '0' WHERE  `services`.`id` =3;
        UPDATE  `happy_giraffe`.`services` SET  `show` =  '0' WHERE  `services`.`id` =4;
        UPDATE  `happy_giraffe`.`services` SET  `show` =  '0' WHERE  `services`.`id` =10;
        UPDATE  `happy_giraffe`.`services` SET  `show` =  '0' WHERE  `services`.`id` =11;
        UPDATE  `happy_giraffe`.`services` SET  `show` =  '0' WHERE  `services`.`id` =12;
        UPDATE  `happy_giraffe`.`services` SET  `show` =  '0' WHERE  `services`.`id` =13;
        UPDATE  `happy_giraffe`.`services` SET  `show` =  '0' WHERE  `services`.`id` =14;
        UPDATE  `happy_giraffe`.`services` SET  `show` =  '0' WHERE  `services`.`id` =15;
        UPDATE  `happy_giraffe`.`services` SET  `show` =  '0' WHERE  `services`.`id` =16;
        ");
	}

	public function down()
	{
		echo "m130909_100703_hide_some_srvices does not support migration down.\n";
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