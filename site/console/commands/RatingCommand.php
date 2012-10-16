<?php
/**
 * Author: alexk984
 * Date: 16.10.12
 */

Yii::import('site.common.models.mongo.*');
Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');
Yii::import('site.frontend.contest.models.*');
Yii::import('site.frontend.modules.services.modules.recipeBook.models.*');
Yii::import('site.frontend.modules.scores.models.*');

class RatingCommand extends CConsoleCommand
{
    public function actionIndex()
    {
        $criteria = new EMongoCriteria;
        $criteria->time('<', time() - 5 * 60);
        $models = RatingQueue::model()->findAll($criteria);

        foreach ($models as $model) {
            $model->updateEntity();
        }
    }
}