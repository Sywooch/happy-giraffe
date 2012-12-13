<?php

class m121205_104753_add_show_to_services extends CDbMigration
{
    private $_table = 'services';

    public function up()
    {
        $this->addColumn($this->_table, 'show', 'tinyint(1) NOT NULL default 1');

        $this->insert($this->_table, array(
            'title' => 'Китайский метод определения пола ребенка',
            'description' => '',
            'url' => 'http://www.happy-giraffe.ru/babySex/china/',
            'category_id' => 2,
            'show'=>0
        ));

        $this->insert($this->_table, array(
            'title' => 'Японский метод планирования пола ребенка',
            'description' => '',
            'url' => 'http://www.happy-giraffe.ru/babySex/japan/',
            'category_id' => 2,
            'show'=>0
        ));

        $this->insert($this->_table, array(
            'title' => 'Пол ребенка по дате рождения родителей',
            'description' => '',
            'url' => 'http://www.happy-giraffe.ru/babySex/bloodRefresh/',
            'category_id' => 2,
            'show'=>0
        ));

        $this->insert($this->_table, array(
            'title' => 'Пол ребенка по группе крови родителей',
            'description' => '',
            'url' => 'http://www.happy-giraffe.ru/babySex/blood/',
            'category_id' => 2,
            'show'=>0
        ));

        $this->insert($this->_table, array(
            'title' => 'Планирование пола ребенка по овуляции',
            'description' => '',
            'url' => 'http://www.happy-giraffe.ru/babySex/ovulation/',
            'category_id' => 2,
            'show'=>0
        ));
    }

    public function down()
    {
        echo "m121205_104753_add_show_to_services does not support migration down.\n";
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