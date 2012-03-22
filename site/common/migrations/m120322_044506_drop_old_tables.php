<?php

class m120322_044506_drop_old_tables extends CDbMigration
{
	public function up()
	{
//        $this->execute('SET foreign_key_checks = 0; drop table IF EXISTS seo_keywords;');
//        $this->execute('SET foreign_key_checks = 0; drop table IF EXISTS seo_stats;');
        $this->execute('drop table IF EXISTS club_photo_comment');
        $this->execute('drop table IF EXISTS shop_product_comment');
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