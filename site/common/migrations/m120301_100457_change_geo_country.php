<?php

class m120301_100457_change_geo_country extends CDbMigration
{
	public function up()
	{
        $this->execute("UPDATE geo_country SET iso_code = lower(iso_code)");
	}

	public function down()
	{
		$this->execute("UPDATE geo_country set iso_code = upper(iso_code)");
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