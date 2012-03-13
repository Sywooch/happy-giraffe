<?php

class m120313_050813_add_score_timeout extends CDbMigration
{
    private $_table = 'score__actions';

	public function up()
	{
        $this->addColumn($this->_table, 'wait_time', 'int not null default 0');
        $this->update($this->_table, array('wait_time'=>720), 'id=4');
        $this->update($this->_table, array('wait_time'=>720), 'id=5');
        $this->update($this->_table, array('wait_time'=>60), 'id=14');
        $this->update($this->_table, array('wait_time'=>720), 'id=15');
        $this->update($this->_table, array('wait_time'=>60), 'id=6');
	}

	public function down()
	{
		$this->dropColumn($this->_table,'wait_time');
	}
}