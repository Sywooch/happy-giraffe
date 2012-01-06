<?php

class m120105_112452_change_vote_columns extends CDbMigration
{
    private $_table = 'recipeBook_recipe_vote';
	public function up()
	{
        $this->dropForeignKey($this->_table . '_recipe_fk', $this->_table);
        $this->truncateTable($this->_table);
        $this->dropColumn($this->_table,'recipe_id');
        $this->addColumn($this->_table, 'object_id', 'int UNSIGNED not null');
        $this->addForeignKey($this->_table . '_recipe_fk', $this->_table, 'object_id', 'recipeBook_recipe', 'id', 'CASCADE', "CASCADE");
	}

	public function down()
	{
        $this->truncateTable($this->_table);
        $this->dropForeignKey($this->_table . '_recipe_fk', $this->_table);
        $this->dropColumn($this->_table,'object_id');
        $this->addColumn($this->_table, 'recipe_id', 'int(11) UNSIGNED not null');
        $this->addForeignKey($this->_table . '_recipe_fk', $this->_table, 'recipe_id', 'recipeBook_recipe', 'id', 'CASCADE', "CASCADE");
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