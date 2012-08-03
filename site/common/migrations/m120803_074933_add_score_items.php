<?php

class m120803_074933_add_score_items extends CDbMigration
{
    private $_table = 'score__actions';
	public function up()
	{
        $this->insert($this->_table, array(
            'id'=>24,
            'title'=>'Анкета - место жительства',
            'scores_weight'=>0,
            'wait_time'=>0
        ));
        $this->insert($this->_table, array(
            'id'=>25,
            'title'=>'Анкета - подтверждение email',
            'scores_weight'=>0,
            'wait_time'=>0
        ));
        $this->insert($this->_table, array(
            'id'=>26,
            'title'=>'Пройдено 6 первых шагов',
            'scores_weight'=>100,
            'wait_time'=>0
        ));
    }

	public function down()
	{
		echo "m120803_074933_add_score_items does not support migration down.\n";
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