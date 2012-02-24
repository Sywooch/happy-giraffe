<?php

class m120221_125223_drop_moder_signals extends CDbMigration
{
    private $_table = 'moderation_signals';

    public function up()
    {
        $this->dropTable($this->_table);
    }

    public function down()
    {
        $this->createTable($this->_table,
            array(
                'id' => 'pk',
                'user_id' => 'int(11) UNSIGNED',
                'type' => 'int(1)',
                'item_name' => 'varchar(256)',
                'item_id' => 'int(11) UNSIGNED',
            ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');
    }
}