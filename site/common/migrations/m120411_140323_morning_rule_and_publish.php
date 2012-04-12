<?php

class m120411_140323_morning_rule_and_publish extends CDbMigration
{
    private $_table = 'auth_item';

	public function up()
	{
        $this->insert($this->_table, array(
            'name' => 'editMorning',
            'type' => '0',
            'description' => 'редактирование фотоблога "Утро с Веселым Жирафом"',
        ));

        $this->_table = 'club_community_photo_post';
        $this->addColumn($this->_table, 'is_published', 'tinyint(1) default 0');
	}

	public function down()
	{
		echo "m120411_140323_morning_rule_and_publish does not support migration down.\n";
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