<?php

class m111128_140225_add_user_with_childs extends CDbMigration
{
	public function up()
	{
        $this->execute("INSERT INTO  `happy_giraffe`.`user` (
        `id` ,
        `external_id` ,
        `vk_id` ,
        `nick` ,
        `email` ,
        `phone` ,
        `password` ,
        `first_name` ,
        `last_name` ,
        `pic_small` ,
        `role` ,
        `link` ,
        `country` ,
        `city` ,
        `gender` ,
        `birthday` ,
        `settlement_id` ,
        `mail_id`
        )
        VALUES (
        '9987' ,  '',  '',  '',  'test999@gmail.com',  '',  '202cb962ac59075b964b07152d234b70',  'Наталья',  'Иванова',  '',  'user',  '',  '',  '',  '1', NULL , NULL , NULL
        );");

        $this->execute("INSERT INTO  `happy_giraffe`.`user_baby` (
        `id` ,
        `parent_id` ,
        `age_group` ,
        `name` ,
        `birthday`
        )
        VALUES (
        NULL ,  '9987',  '1',  'Тема',  '2007-11-13'
        ), (
        NULL ,  '9987',  '1',  'Надюша',  '2011-11-15'
        );
        ");
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