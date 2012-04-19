<?php

class m120418_073214_rename_services extends CDbMigration
{
	public function up()
	{
        $this->renameTable('horoscope', 'services__horoscope');
        $this->renameTable('placenta_thickness', 'services__placenta_thickness');
        $this->renameTable('pregnancy_weight', 'services__pregnancy_weight');
	}

	public function down()
	{
		echo "m120418_073214_rename_services does not support migration down.\n";
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