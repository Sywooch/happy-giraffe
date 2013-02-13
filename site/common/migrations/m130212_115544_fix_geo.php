<?php

class m130212_115544_fix_geo extends CDbMigration
{
    private $_table = 'geo__city';

    public function up()
    {
        $this->update($this->_table, array(
            'district_id' => 804,
            'region_id' => 42,
        ), 'id=53660');
        $this->update($this->_table, array(
            'district_id' => 756,
            'region_id' => 40,
        ), 'id=58239');

        $this->execute("
UPDATE  `happy_giraffe`.`geo__region` SET  `name` =  'Республика Северная Осетия-Алания' WHERE  `geo__region`.`id` =207;
UPDATE  `happy_giraffe`.`geo__region` SET  `name` =  'Ровенская область' WHERE  `geo__region`.`id` =14;
UPDATE  `happy_giraffe`.`geo__region` SET  `name` =  'Карачаево-Черкесская Республика' WHERE  `geo__region`.`id` =206;
UPDATE  `happy_giraffe`.`geo__region` SET  `name` =  'Чеченская Республика' WHERE  `geo__region`.`id` =252;
UPDATE  `happy_giraffe`.`geo__region` SET  `name` =  'Еврейская автономная область' WHERE  `geo__region`.`id` =192;
UPDATE  `happy_giraffe`.`geo__region` SET  `name` =  'Костанайская область' WHERE  `geo__region`.`id` =82;
        ");

        $this->_table = 'geo__region';
        $this->addColumn($this->_table, 'auto_created', 'tinyint(2)');
        $this->_table = 'geo__district';
        $this->addColumn($this->_table, 'auto_created', 'tinyint(2)');
        $this->_table = 'geo__city';
        $this->addColumn($this->_table, 'auto_created', 'tinyint(2)');
        $this->addColumn($this->_table, 'declension_checked', 'tinyint(1) not null default 0');
    }

    public function down()
    {
        $this->dropColumn($this->_table,'geo__region');
        $this->dropColumn($this->_table,'geo__district');
        $this->dropColumn($this->_table,'geo__city');
        $this->dropColumn($this->_table,'declension_checked');
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