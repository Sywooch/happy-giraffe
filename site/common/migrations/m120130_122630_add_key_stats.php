<?php

class m120130_122630_add_key_stats extends CDbMigration
{
    private $_table = 'seo_keywords';

    public function up()
    {
        $this->createTable($this->_table,
            array(
                'id' => 'pk',
                'name' => 'varchar(1024)'
            ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');

        $this->_table = 'seo_stats';
        $this->createTable($this->_table,
            array(
                'id' => 'pk',
                'keyword_id' => 'int not null',
                'year'=>'int not null',
                'month'=>'int not null',
                'value'=>'int',
            ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');

        $this->addForeignKey($this->_table.'_keyword_fk', $this->_table, 'keyword_id', 'seo_keywords', 'id','CASCADE',"CASCADE");
    }

    public function down()
    {
        $this->_table = 'seo_stats';
        $this->dropForeignKey($this->_table . '_keyword_fk', $this->_table);
        $this->dropTable($this->_table);
        $this->_table = 'seo_keywords';
        $this->dropTable($this->_table);
    }
}