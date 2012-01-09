<?php

class m120109_064524_recipe_vote_fix extends CDbMigration
{
    private $_table = 'recipeBook_recipe_vote';

	public function up()
	{
        $this->truncateTable($this->_table);
        $this->dropForeignKey($this->_table.'_user_fk', $this->_table);
        $this->dropColumn($this->_table, 'user_id');
        $this->addColumn($this->_table, 'user_id', 'int unsigned not null');

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