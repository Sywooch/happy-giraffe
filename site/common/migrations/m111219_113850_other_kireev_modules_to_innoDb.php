<?php

class m111219_113850_other_kireev_modules_to_innoDb extends CDbMigration
{
	public function up()
	{
        $this->truncateTable('menstrual_user_cycle');
        $this->execute('ALTER TABLE  `pregnancy_weight` ENGINE = INNODB');
        $this->execute('ALTER TABLE  `placentaThickness` ENGINE = INNODB');
        $this->execute('ALTER TABLE  `menstrual_cycle` ENGINE = INNODB');
        $this->execute('ALTER TABLE  `menstrual_user_cycle` ENGINE = INNODB');
        $this->alterColumn('menstrual_user_cycle', 'user_id', 'int UNSIGNED');
        $this->addForeignKey('menstrual_user_cycle_user_fk', 'menstrual_user_cycle', 'user_id',
            'user', 'id','CASCADE',"CASCADE");
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