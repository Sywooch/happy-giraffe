<?php

class m120416_120751_rename_vaccine extends CDbMigration
{
	public function up()
	{
        $this->execute('DROP TABLE IF EXISTS vaccine_user_vote');

        $this->renameTable('vaccine', 'vaccine__vaccines');
        $this->renameTable('vaccine_date', 'vaccine__dates');
        $this->renameTable('vaccine_date_disease', 'vaccine__dates_diseases');
        $this->renameTable('vaccine_date_vote', 'vaccine__dates_votes');
        $this->renameTable('vaccine_disease', 'vaccine__diseases');
	}

	public function down()
	{
		echo "m120416_120751_rename_vaccine does not support migration down.\n";
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