<?php

class m130813_081226_interests_fis extends CDbMigration
{
    private $_table = 'interest__interests';
	public function up()
	{
        $this->alterColumn($this->_table, 'category_id', 'int(2) UNSIGNED null');
	}

	public function down()
	{
		echo "m130813_081226_interests_fis does not support migration down.\n";
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