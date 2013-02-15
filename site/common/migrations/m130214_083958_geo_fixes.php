<?php

class m130214_083958_geo_fixes extends CDbMigration
{
	public function up()
	{
        $this->execute("
        UPDATE  `happy_giraffe`.`geo__region` SET  `name` =  'Республика Кабардино-Балкария' WHERE  `geo__region`.`id` =268;
        UPDATE  `happy_giraffe`.`geo__region` SET  `name` =  'Ханты-Мансийский автономный округ - Югра' WHERE  `geo__region`.`id` =200;
        UPDATE  `happy_giraffe`.`geo__region` SET  `name` =  'Республика Карачаево-Черкессия' WHERE  `geo__region`.`id` =206;
        UPDATE  `happy_giraffe`.`geo__region` SET  `name` =  'Кызылординская область' WHERE  `geo__region`.`id` =83;
        ALTER TABLE  `routes__coordinates` CHANGE  `lat`  `lat` FLOAT( 6,3 ) NOT NULL;
        ALTER TABLE  `routes__coordinates` CHANGE  `lng`  `lng` FLOAT( 6,3 ) NOT NULL;
        ALTER TABLE `routes__coordinates` DROP `id`;
        ALTER TABLE  `routes__coordinates` ADD PRIMARY KEY (  `lat` ,  `lng` ) ;
        UPDATE  `happy_giraffe`.`geo__region` SET  `name` =  'Республика Чувашская - Чувашия' WHERE  `geo__region`.`id` =210;
        ALTER TABLE  `routes__links` CHANGE  `anchor`  `anchor` TINYINT NOT NULL;
        UPDATE  `happy_giraffe`.`geo__region` SET  `name` =  'Республика Удмуртия' WHERE  `geo__region`.`id` =242;
        UPDATE  `happy_giraffe`.`geo__region` SET  `name` =  'Алматинская область' WHERE  `geo__region`.`id` =75;
        ALTER TABLE  `routes__routes` CHANGE  `active`  `status` TINYINT( 5 ) NOT NULL DEFAULT  '0';
        RENAME TABLE  `happy_giraffe`.`routes__rosn_points` TO  `happy_giraffe`.`routes__points` ;
        ALTER TABLE  `comments` CHANGE  `entity`  `entity` ENUM(  'AlbumPhoto',  'BlogContent',  'CommunityContent',  'ContestWork',  'RecipeBookRecipe',  'User',  'Product',  'CookChoose',  'CookRecipe', 'Service',  'Route' ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
        ALTER TABLE  `geo__region` ADD  `google_name` VARCHAR( 255 ) NULL AFTER  `name`;

        UPDATE  `happy_giraffe`.`geo__region` SET  `google_name` =  'Республика Чечения' WHERE  `geo__region`.`id` =252;
        UPDATE  `happy_giraffe`.`geo__region` SET  `google_name` =  'Республика Саха /Якутия/' WHERE  `geo__region`.`id` =243;

        ");
	}

	public function down()
	{
		echo "m130214_083958_geo_fixes does not support migration down.\n";
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