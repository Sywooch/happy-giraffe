<?php

class m111228_181324_recipe_add_rating extends CDbMigration
{
    private $_table = 'recipeBook_recipe_vote';

    public function up()
    {
        $this->createTable($this->_table,
            array(
                'user_id' => 'int unsigned NOT NULL',
                'recipe_id' => 'int(11) unsigned NOT NULL',
                'vote' => 'int(1) NOT NULL',
                'PRIMARY KEY (user_id, recipe_id)'
            ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');

        $this->addForeignKey($this->_table . '_user_fk', $this->_table, 'user_id', 'user', 'id', 'CASCADE', "CASCADE");
        $this->addForeignKey($this->_table . '_recipe_fk', $this->_table, 'recipe_id', 'recipeBook_recipe', 'id', 'CASCADE', "CASCADE");

        $this->_table = 'recipeBook_recipe';
        $this->addColumn($this->_table, 'votes_pro', 'int unsigned default 0 not null');
        $this->addColumn($this->_table, 'votes_con', 'int unsigned default 0 not null');
    }

    public function down()
    {
        $this->dropTable($this->_table);
        $this->_table = 'recipeBook_recipe';
        $this->dropColumn($this->_table,'votes_pro');
        $this->dropColumn($this->_table,'votes_con');
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