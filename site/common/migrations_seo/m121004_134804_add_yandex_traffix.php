<?php

class m121004_134804_add_yandex_traffix extends CDbMigration
{
    private $_table = 'pages_search_phrases';

    public function up()
    {
        $this->addColumn($this->_table, 'yandex_traffic', 'int NOT NULL default 0');
    }

    public function down()
    {
        $this->dropColumn($this->_table, 'yandex_traffic');
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