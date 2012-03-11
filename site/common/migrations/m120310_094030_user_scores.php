<?php

class m120310_094030_user_scores extends CDbMigration
{
    private $_table = 'score__levels';

    public function up()
    {
        $this->createTable($this->_table,
            array(
                'id' => 'int unsigned NOT NULL auto_increment',
                'name' => 'varchar(256)',
                'css_class' => 'varchar(256)',
                'score_cost' => 'int not null',
                'PRIMARY KEY (`id`)'
            ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');

        $this->_table = 'user_scores';
        $this->createTable($this->_table,
            array(
                'user_id' => 'int unsigned NOT NULL',
                'scores' => 'int unsigned default 0',
                'level_id' => 'int unsigned',
                'PRIMARY KEY (`user_id`)'
            ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');

        $this->addForeignKey($this->_table . '_user_fk', $this->_table, 'user_id', 'user', 'id', 'CASCADE', "CASCADE");
        $this->addForeignKey($this->_table.'_level_fk', $this->_table, 'level_id', 'score__levels', 'id','CASCADE',"CASCADE");

        $this->_table = 'score__actions';
        $this->createTable($this->_table,
            array(
                'id' => 'int unsigned NOT NULL',
                'title' => 'varchar(256)',
                'scores_weight' => 'int not null',
                'PRIMARY KEY (`id`)'
            ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');
    }

    public function down()
    {
        $this->_table = 'score__actions';
        $this->dropTable($this->_table);

        $this->_table = 'user_scores';
        $this->dropForeignKey($this->_table . '_user_fk', $this->_table);
        $this->dropForeignKey($this->_table . '_level_fk', $this->_table);
        $this->dropTable($this->_table);

        $this->_table = 'score__levels';
        $this->dropTable($this->_table);
    }
}