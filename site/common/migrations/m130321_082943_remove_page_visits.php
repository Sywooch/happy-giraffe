<?php

class m130321_082943_remove_page_visits extends CDbMigration
{
    public function up()
    {
        Yii::import('site.frontend.modules.signal.models.*');
        Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');

        $modifier = new EMongoModifier(array(
            'page_visits' => array('unset' => 1),
        ));
        CommentatorsMonth::model()->updateAll($modifier);
    }

    public function down()
    {
        echo "m130321_082943_remove_page_visits does not support migration down.\n";
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
