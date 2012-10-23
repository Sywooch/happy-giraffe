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

    public function actionSync($social_key = null)
    {
        $models = ContestWork::model()->findAll('contest_id = 2');
        $count = count($models);
        foreach ($models as $i => $model) {
            $attach = AttachPhoto::model()->findByEntity('ContestWork', $model->id);
            $photo = $attach[0]->photo;
            $url = 'http://www.happy-giraffe.ru/contest/' . $model->contest_id . '/photo' . $photo->id . '/';
            if ($social_key === null) {
                Rating::updateByApi($model, 'fb', $url);
                Rating::updateByApi($model, 'tw', $url);
                Rating::updateByApi($model, 'vk', $url);
                Rating::updateByApi($model, 'ok', $url);
            } else {
                Rating::updateByApi($model, $social_key, $url);
            }
            echo ($i + 1) . '/' . $count . '|' . $url . "\n";
        }
    }

    public function actionCalc()
    {
        //$models = ContestWork::model()->findAll('contest_id = 2');
        $models = array(ContestWork::model()->findByPk(541));

        foreach ($models as $model) {
            $criteria = new EMongoCriteria();
            $criteria->entity_id('==', (int)$model->id);
            $criteria->entity_name('==', 'ContestWork');
            $yohoho = RatingYohoho::model()->count($criteria);

            $rating = Rating::model()->find($criteria);
            if ($rating !== null) {
                $rating->ratings['yh'] = $yohoho * 2;
                echo $rating->ratings['yh'] . "\n";
                $rating->save();
            }
        }
    }
}