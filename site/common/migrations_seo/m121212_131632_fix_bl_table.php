<?php

class m121212_131632_fix_bl_table extends CDbMigration
{
    private $_table = 'keyword_blacklist';

	public function up()
	{
        $this->addColumn($this->_table, 'user_id', 'int(10) unsigned NOT NULL');
        $this->renameTable($this->_table, 'keywords__blacklist');

        $this->_table = 'keywords__blacklist';
        Yii::app()->db->createCommand()->update($this->_table, array('user_id'=>33));

        $this->addForeignKey('fk_'.$this->_table.'_user', $this->_table, 'user_id', 'users', 'id','CASCADE',"CASCADE");
	}

	public function down()
	{
		echo "m121212_131632_fix_bl_table does not support migration down.\n";
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