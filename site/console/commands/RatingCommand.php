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
Yii::import('site.frontend.modules.contest.models.*');

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

    public function actionSync()
    {
        $models = ContestWork::model()->findAll();
        foreach ($models as $model) {
            $attach = AttachPhoto::model()->findByEntity('ContestWork', $model->id);
            $photo = $attach[0]->photo;
            $url = 'http://www.happy-giraffe.ru' . ltrim(Yii::app()->createUrl('albums/singlePhoto', array('entity' => 'Contest', 'contest_id' => $model->contest_id, 'photo_id' => $photo->id)), '.');
            Rating::updateByApi($model, 'fb', $url);
            Rating::updateByApi($model, 'tw', $url);
            Rating::updateByApi($model, 'vk', $url);
            Rating::updateByApi($model, 'ok', $url);
        }
    }
}