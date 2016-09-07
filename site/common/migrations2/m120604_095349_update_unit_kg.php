<?php

class m120604_095349_update_unit_kg extends CDbMigration
{
    public function up()
    {
        $this->update('cook__units', array(
            'title' => 'килограмм',
            'title2' => 'килограмма',
            'title3' => 'килограммов'
        ), 'id=:id', array(':id' => 2));
        $this->update('cook__units', array(
            'title3' => 'граммов'
        ), 'id=:id', array(':id' => 1));
    }

    public function down()
    {
        echo "m120604_095349_update_unit_kg does not support migration down.\n";
        return false;
    }
}