<?php

class m111220_055852_user_to_innoDb extends CDbMigration
{
    private $_table = 'user_points_history';

	public function up()
	{
        $this->execute('ALTER TABLE  `user_points_history` ENGINE = INNODB');
        $this->execute('ALTER TABLE  `user_social_service` ENGINE = INNODB');
        $this->addForeignKey($this->_table.'_user_fk', $this->_table, 'user_id', 'user', 'id','CASCADE',"CASCADE");
        $this->_table = 'user_social_service';
        $this->addForeignKey($this->_table.'_user_fk', $this->_table, 'user_id', 'user', 'id','CASCADE',"CASCADE");
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