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
        $user_not_set = RecipeBookRecipe::model()->findAll('user_id IS NULL');

        foreach ($user_not_set as $model) {
            $model->user_id = $user_ids[rand(0, count($user_ids)-1)];
            $model->update('user_id');
        }
    }

    public function down()
    {

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