<?php

class m120217_113731_moder_signal extends CDbMigration
{
    private $_table = 'moderation_signals';

	public function up()
	{
        $this->createTable($this->_table,
           array(
                'id'=>'pk',
               'user_id'=>'int(11) UNSIGNED',
               'type'=>'int(1)',
               'item_name'=>'varchar(256)',
               'item_id'=>'int(11) UNSIGNED',
           ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');
        $this->addForeignKey($this->_table.'_user_fk', $this->_table, 'user_id', 'user', 'id','CASCADE',"CASCADE");
	}

	public function down()
	{
		$this->dropForeignKey($this->_table . '_user_fk', $this->_table);
        $this->dropTable($this->_table);
	}
}