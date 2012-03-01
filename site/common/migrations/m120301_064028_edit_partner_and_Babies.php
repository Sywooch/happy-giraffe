<?php

class m120301_064028_edit_partner_and_Babies extends CDbMigration
{
    private $_table = 'user_partner';

    public function up()
    {
        $this->createTable($this->_table,
            array(
                'id'=>'pk',
                'user_id' => 'int(11) unsigned not null',
                'name' => 'varchar(255)',
                'photo' => 'varchar(255)',
                'notice' => 'varchar(1024)',
            ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');
        $this->addForeignKey($this->_table.'_user_fk', $this->_table, 'user_id', 'user', 'id','CASCADE',"CASCADE");

        $this->_table = 'user_baby';
        $this->addColumn($this->_table, 'photo', 'varchar(255)');
        $this->addColumn($this->_table, 'notice', 'varchar(1024)');

        $this->_table = 'user';
        $this->dropColumn($this->_table,'partner_name');
    }

    public function down()
    {
        $this->dropForeignKey($this->_table . '_user_fk', $this->_table);
        $this->dropTable($this->_table);

        $this->_table = 'user_baby';
        $this->dropColumn($this->_table,'photo');

        $this->_table = 'user';
        $this->addColumn($this->_table,'partner_name', 'varchar(255)');
    }
}