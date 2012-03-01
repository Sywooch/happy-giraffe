<?php

class m120229_105043_user_interests extends CDbMigration
{
    private $_table = '';

    public function up()
    {
        $this->_table = 'interest_category';
        $this->createTable($this->_table,
            array(
                'id' => 'int(1) unsigned auto_increment not null',
                'name' => 'varchar(255) not null',
                'css_class' => 'varchar(255)',
                'PRIMARY KEY (id)'
            ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');

        $this->_table = 'interest';
        $this->createTable($this->_table,
            array(
                'id' => 'int(1) unsigned auto_increment not null',
                'name' => 'varchar(255) not null',
                'category_id' => 'int(1) unsigned not null',
                'PRIMARY KEY (id)'
            ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');
        $this->addForeignKey($this->_table . '_category_fk', $this->_table, 'category_id', 'interest_category', 'id', 'CASCADE', "CASCADE");

        $this->_table = 'user_interest';
        $this->createTable($this->_table,
            array(
                'user_id' => 'int unsigned not null',
                'interest_id' => 'int(1) unsigned not null',
                'PRIMARY KEY (user_id, interest_id)'
            ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');

        $this->addForeignKey($this->_table . '_user_fk', $this->_table, 'user_id', 'user', 'id', 'CASCADE', "CASCADE");
        $this->addForeignKey($this->_table . '_interest_fk', $this->_table, 'interest_id', 'interest', 'id', 'CASCADE', "CASCADE");
    }

    public function down()
    {
        $this->_table = 'user_interest';
        $this->dropForeignKey($this->_table . '_interest_fk', $this->_table);
        $this->dropForeignKey($this->_table . '_user_fk', $this->_table);
        $this->dropTable($this->_table);

        $this->_table = 'interest';
        $this->dropForeignKey($this->_table . '_category_fk', $this->_table);
        $this->dropTable($this->_table);

        $this->_table = 'interest_category';
        $this->dropTable($this->_table);
    }
}