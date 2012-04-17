<?php

class m120328_083228_add_score_actions extends CDbMigration
{
    private $_table = 'score__actions';
	public function up()
	{
        $this->insert($this->_table, array(
            'id'=>'16',
            'title'=>'Первая запись в блог',
            'scores_weight'=>'30',
            'wait_time'=>'0',
        ));
        $this->insert($this->_table, array(
            'id'=>'17',
            'title'=>'Участие в конкурсе',
            'scores_weight'=>'10',
            'wait_time'=>'0',
        ));
        $this->insert($this->_table, array(
            'id'=>'18',
            'title'=>'Победа в конкрусе',
            'scores_weight'=>'250',
            'wait_time'=>'0',
        ));
        $this->insert($this->_table, array(
            'id'=>'19',
            'title'=>'Второе место в конкурсе',
            'scores_weight'=>'200',
            'wait_time'=>'0',
        ));
        $this->insert($this->_table, array(
            'id'=>'20',
            'title'=>'Третье место в конкурсе',
            'scores_weight'=>'150',
            'wait_time'=>'0',
        ));
        $this->insert($this->_table, array(
            'id'=>'21',
            'title'=>'Четвертое место в конкурсе',
            'scores_weight'=>'100',
            'wait_time'=>'0',
        ));
        $this->insert($this->_table, array(
            'id'=>'22',
            'title'=>'Пятое место в конкурсе',
            'scores_weight'=>'50',
            'wait_time'=>'0',
        ));
        $this->insert($this->_table, array(
            'id'=>'23',
            'title'=>'Дополнительный приз в конкурсе',
            'scores_weight'=>'50',
            'wait_time'=>'0',
        ));

	}

	public function down()
	{
		echo "m120328_083228_add_score_actions does not support migration down.\n";
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