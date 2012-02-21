<?php

class m120221_090641_fix_recipe_authors extends CDbMigration
{
    private $_table = 'recipeBook_recipe';

    public function up()
    {
        Yii::import('site.frontend.modules.recipeBook.models.*');
        Yii::import('site.frontend.components.*');
        $user_ids = Yii::app()->db->createCommand('select DISTINCT user_id from recipeBook_recipe WHERE user_id IS NOT NULL')->queryColumn();
        print_r($user_ids);

        $user_not_set = Yii::app()->db->createCommand('select * from recipeBook_recipe WHERE user_id IS NULL')->queryAll();

        if (!empty($user_ids))
            foreach ($user_not_set as $row) {
                $user_id = $user_ids[rand(0, count($user_ids) - 1)];
                Yii::app()->db->createCommand()->update('recipeBook_recipe',
                    array('user_id' => $user_id), 'id=' . $row['id']);
            }
    }

    public function down()
    {

    }
}