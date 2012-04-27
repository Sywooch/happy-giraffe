<?php

class m120427_192857_tree_test extends CDbMigration
{
    private $_table = 'test__question_answers';

	public function up()
	{
        $this->addColumn($this->_table, 'next_question_id', 'int(11)');
        $this->addColumn($this->_table, 'result_id', 'int(11)');

        $this->addForeignKey('fk_'.$this->_table.'_next_question', $this->_table, 'next_question_id', 'test__questions', 'id','CASCADE',"CASCADE");
        $this->addForeignKey('fk_'.$this->_table.'_result', $this->_table, 'result_id', 'test__results', 'id','CASCADE',"CASCADE");
	}

	public function down()
	{
		echo "m120427_192857_tree_test does not support migration down.\n";
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