<?php

class m111228_165858_recipe_add_columns extends CDbMigration
{
    private $_table = 'recipeBook_recipe';

	public function up()
	{
        $this->addColumn($this->_table, 'user_id', 'int unsigned after disease_id');
        $this->addColumn($this->_table, 'create_time', 'datetime not null');
        $this->addColumn($this->_table, 'views_amount', 'int not null');

        $this->addForeignKey($this->_table.'_user_fk', $this->_table, 'user_id', 'user', 'id','CASCADE',"CASCADE");
	}

	public function down()
	{
        $this->dropForeignKey($this->_table.'_user_fk', $this->_table);
        $this->dropColumn($this->_table,'views_amount');
        $this->dropColumn($this->_table,'create_time');
        $this->dropColumn($this->_table,'user_id');
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