<?php

class m120123_080437_name_motule_fixes extends CDbMigration
{
    private $_table = 'name_option';

    public function up()
    {
        $this->createTable($this->_table,
            array(
                'id' => 'pk',
                'name_id' => 'int(10) UNSIGNED not null',
                'value' => 'varchar(255)'
            ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');
        $this->addForeignKey($this->_table.'_name_fk', $this->_table, 'name_id', 'name', 'id','CASCADE',"CASCADE");

        $this->_table = 'name_sweet';
        $this->createTable($this->_table,
            array(
                'id' => 'pk',
                'name_id' => 'int(10) UNSIGNED not null',
                'value' => 'varchar(255)'
            ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');
        $this->addForeignKey($this->_table.'_name_fk', $this->_table, 'name_id', 'name', 'id','CASCADE',"CASCADE");

        $this->_table = 'name_middle';
        $this->createTable($this->_table,
            array(
                'id' => 'pk',
                'name_id' => 'int(10) UNSIGNED not null',
                'value' => 'varchar(255)'
            ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');
        $this->addForeignKey($this->_table.'_name_fk', $this->_table, 'name_id', 'name', 'id','CASCADE',"CASCADE");
    }

    public function down()
    {
        $this->dropForeignKey($this->_table.'_name_fk', $this->_table);
        $this->dropTable($this->_table);

        $this->_table = 'name_sweet';
        $this->dropForeignKey($this->_table.'_name_fk', $this->_table);
        $this->dropTable($this->_table);

        $this->_table = 'name_middle';
        $this->dropForeignKey($this->_table.'_name_fk', $this->_table);
        $this->dropTable($this->_table);
    }
}