<?php

class m120416_115105_remove_seo_tables extends CDbMigration
{
	public function up()
	{
        $this->execute('DROP TABLE IF EXISTS seo_stats');
        $this->execute('DROP TABLE IF EXISTS seo_keywords');

        $this->execute('DROP TABLE IF EXISTS seo__stats');
        $this->execute('DROP TABLE IF EXISTS seo__key_stats');
        $this->execute('DROP TABLE IF EXISTS seo__keywords');
        $this->execute('DROP TABLE IF EXISTS seo__site');
	}

	public function down()
	{
		echo "m120416_115105_remove_seo_tables does not support migration down.\n";
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