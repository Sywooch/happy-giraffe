<?php

class m130831_120804_add_service_many_many_community extends CDbMigration
{
    private $_table = 'services';

    public function up()
    {
        $this->dropForeignKey('services_ibfk_1', $this->_table);
        $this->dropColumn($this->_table, 'category_id');
        $this->dropTable('services__categories');

        $this->_table = 'services__communities';
        $this->createTable($this->_table,
            array(
                'service_id' => 'int UNSIGNED not null',
                'community_id' => 'int UNSIGNED not null',
                'PRIMARY KEY (service_id, community_id)'
            ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');

        $this->addForeignKey('fk_'.$this->_table.'_service', $this->_table, 'service_id', 'services', 'id','CASCADE',"CASCADE");
        $this->addForeignKey('fk_'.$this->_table.'_community', $this->_table, 'community_id', 'community__communities', 'id','CASCADE',"CASCADE");
    }

    public function down()
    {
        echo "m130831_120804_add_service_many_many_community does not support migration down.\n";
        return false;
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