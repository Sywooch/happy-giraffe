<?php

class m141009_055942_auth_adveditor extends CDbMigration
{
	public function up()
	{
        $this->insert('auth__items', array(
            'name' => 'advEditor',
            'type' => 0,
            'description' => 'Расширенный редактор',
        ));
	}

	public function down()
	{
		echo "m141009_055942_auth_adveditor does not support migration down.\n";
		return false;
	}
}