<?php

class m170403_084055_add_greeting_to_specialists__profiles extends CDbMigration
{
	public function up()
	{
        $this->addColumn('specialists__profiles', 'greeting', 'varchar(200)');
	}

	public function down()
	{
		$this->dropColumn('specialists__profiles', 'greeting');
	}
}