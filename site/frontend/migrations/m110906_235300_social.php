<?php

class m110906_235300_social extends CDbMigration
{
    public function up()
    {
	$this->addColumn('club_user', 'mail_id', 'bigint(25) unsigned null');
    }
 
    public function down()
    {
        echo "m110906_235300_social does not support migration down.\n";
        return false;
    }
}