<?php

class m120229_083703_horoscope extends CDbMigration
{
    private $_table = 'horoscope';
    public function up()
    {
        $this->createTable($this->_table,
            array(
                'id' => 'pk',
                'zodiac' => 'tinyint(4) not null',
                'date' => 'date not null',
                'text'=>'text not null',
            ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');
    }

    public function down()
    {
        $this->dropTable($this->_table);
    }
}