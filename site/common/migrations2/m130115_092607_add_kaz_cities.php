<?php

class m130115_092607_add_kaz_cities extends CDbMigration
{
    private $_table = 'geo__city';

    public function up()
    {
        $this->insert($this->_table, array(
            
            'region_id' => 74,
            'country_id' => 109,
            'name' => 'Актюбинск',
            'type' => 'г',
        ));

        $this->update($this->_table, array('name'=>'Арыс', 'type'=>'г'), 'id=79579');

        $this->insert($this->_table, array(
            
            'region_id' => 77,
            'country_id' => 109,
            'name' => 'Атырау',
            'type' => 'г',
        ));

        $this->update($this->_table, array('name'=>'Жезказган', 'type'=>'г'), 'id=78564');
        $this->update($this->_table, array('name'=>'Джетысай', 'type'=>'г'), 'id=79666');

        $this->insert($this->_table, array(
            
            'region_id' => 74,
            'country_id' => 109,
            'name' => 'Жем',
            'type' => 'г',
        ));

        $this->update($this->_table, array('name'=>'Капчагай', 'type'=>'г'), 'id=77555');

        $this->insert($this->_table, array(
            
            'region_id' => 81,
            'country_id' => 109,
            'name' => 'Караганда',
            'type' => 'г',
        ));

        $this->insert($this->_table, array(
            
            'region_id' => 83,
            'country_id' => 109,
            'name' => 'Кызылорда',
            'type' => 'г',
        ));

        $this->insert($this->_table, array(
            
            'region_id' => 73,
            'country_id' => 109,
            'name' => 'Кокшетау',
            'type' => 'г',
        ));

        $this->insert($this->_table, array(
            
            'region_id' => 82,
            'country_id' => 109,
            'name' => 'Костанай',
            'type' => 'г',
        ));

        $this->insert($this->_table, array(
            
            'region_id' => 86,
            'country_id' => 109,
            'name' => 'Петропавловск',
            'type' => 'г',
        ));

        $this->update($this->_table, array('name'=>'Сарканд', 'type'=>'г'), 'id=77705');

        $this->insert($this->_table, array(
            
            'region_id' => 75,
            'country_id' => 109,
            'name' => 'Талдыкорган',
            'type' => 'г',
        ));

        $this->insert($this->_table, array(
            
            'region_id' => 79,
            'country_id' => 109,
            'name' => 'Тараз',
            'type' => 'г',
        ));

        $this->insert($this->_table, array(
            
            'region_id' => 80,
            'country_id' => 109,
            'name' => 'Уральск',
            'type' => 'г',
        ));

        $this->insert($this->_table, array(
            
            'region_id' => 78,
            'country_id' => 109,
            'name' => 'Усть-Каменогорск',
            'type' => 'г',
        ));

        $this->update($this->_table, array('name'=>'Учарал', 'type'=>'г'), 'id=77653');

        $this->insert($this->_table, array(
            'district_id' => 1182,
            'region_id' => 84,
            'country_id' => 109,
            'name' => 'Форт-Шевченко',
            'type' => 'г',
        ));

        $this->update($this->_table, array('name'=>'Чардара', 'type'=>'г'), 'id=79799');
        $this->update($this->_table, array('name'=>'Чарск', 'type'=>'г'), 'id=77907');
        $this->update($this->_table, array('name'=>'Челкар', 'type'=>'г'), 'id=77318');


        $this->insert($this->_table, array(
            
            'region_id' => 87,
            'country_id' => 109,
            'name' => 'Шымкент',
            'type' => 'г',
        ));
    }

    public function down()
    {
        echo "m130115_092607_add_kaz_cities does not support migration down.\n";
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