<?php

class m120315_105030_add_level extends CDbMigration
{
    private $_table = 'score__levels';
	public function up()
	{
        $this->insert($this->_table,array(
            'name'=>'Восход',
            'css_class'=>'sunrise',
            'score_cost'=>'100',
        ));
	}

	public function down()
	{
		$this->truncateTable($this->_table);
	}
}