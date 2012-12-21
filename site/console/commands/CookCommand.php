<?php
/**
 * Author: alexk984
 * Date: 13.12.12
 */
Yii::import('site.frontend.modules.cook.models.*');
Yii::import('site.frontend.modules.cook.components.*');
Yii::import('site.frontend.modules.geo.models.*');

class CookCommand extends CConsoleCommand
{
    public function actionIndex()
    {
        $criteria = new CDbCriteria;
        $criteria->limit = 100;
        $criteria->offset = 0;
        $criteria->order = 'id desc';

        $models = array(0);
        while (!empty($models)) {
            $models = CookRecipe::model()->findAll($criteria);
            foreach ($models as $recipe)
                if ($recipe->section == 1 && !empty($recipe->tags)) {
                    $recipe->tags = array();
                    Yii::app()->db->createCommand()->delete('cook__recipe_recipes_tags',
                        'recipe_id = :recipe_id',
                        array(':recipe_id' => $recipe->id));
                }

            $criteria->offset += 100;
        }

    }
}