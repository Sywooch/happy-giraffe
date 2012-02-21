<?php

class m120221_080515_add_slug_to_names extends CDbMigration
{
    private $_table = 'name';

    public function up()
    {
        $this->addColumn($this->_table, 'slug', 'varchar(255)');

        Yii::import('site.frontend.components.*');
        Yii::import('site.frontend.modules.names.models.*');
        $names = Name::model()->findAll();
        foreach ($names as $name) {
            $name->scenario = Name::SCENARIO_EDIT_NAME;
            $name->update('slug');
        }
    }

    public function down()
    {
        $this->dropColumn($this->_table, 'slug');
    }
}