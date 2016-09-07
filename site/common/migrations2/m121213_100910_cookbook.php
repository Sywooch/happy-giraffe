<?php

class m121213_100910_cookbook extends CDbMigration
{
    private $_table = 'cook__cook_book';

    public function up()
    {
        $this->createTable($this->_table,
            array(
                'recipe_id' => 'int unsigned not null',
                'user_id' => 'int unsigned not null',
                'PRIMARY KEY (recipe_id, user_id)'
            ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');

        $this->addForeignKey('fk_'.$this->_table.'_user', $this->_table, 'user_id', 'users', 'id','CASCADE',"CASCADE");
        $this->addForeignKey('fk_'.$this->_table.'_recipe', $this->_table, 'recipe_id', 'cook__recipes', 'id','CASCADE',"CASCADE");
    }

    public function down()
    {
        echo "m121213_100910_cookbook does not support migration down.\n";
        return false;
    }
}