<?php

class m120111_063432_create_name_stats_table extends CDbMigration
{
    private $_table = 'name_stats';

    public function up()
    {
        $this->createTable($this->_table,
            array(
                'id' => 'pk',
                'name_id' => 'int UNSIGNED not null',
                'month' => 'tinyint(4) unsigned not null',
                'year' => 'SMALLINT unsigned not null',
                'likes' => 'int default 0 not null',
            ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');

        $this->addForeignKey($this->_table.'_name_fk', $this->_table, 'name_id', 'name', 'id','CASCADE',"CASCADE");
    }

    public function down()
    {
        $this->dropForeignKey($this->_table . '_name_fk', $this->_table);
        $this->dropTable($this->_table);
    }

}