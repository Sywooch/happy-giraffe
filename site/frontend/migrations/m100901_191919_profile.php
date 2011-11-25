<?php

class m100901_191919_profile extends CDbMigration
{
    public function up()
    {
	$this->addColumn('club_user', 'gender', 'boolean not null');
	$this->addColumn('club_user', 'birthday', 'date null');
	$this->createTable('club_user_baby', array(
			'id' => 'pk',
			'parent_id' => 'int(11) not null',
			'age_group' => 'tinyint(11) not null',
			'name' => 'varchar(255) not null',
			'birthday' => 'date null',	
		)	
	);
    }
 
    public function down()
    {
        echo "m100901_191919_profile does not support migration down.\n";
        return false;
    }
}