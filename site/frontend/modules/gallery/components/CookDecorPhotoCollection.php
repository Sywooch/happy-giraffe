<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 7/9/13
 * Time: 10:44 AM
 * To change this template use File | Settings | File Templates.
 */

class CookDecorPhotoCollection extends PhotoCollection
{
    protected function generateIds()
    {
        return Yii::app()->db->createCommand("SELECT photo_id FROM cook__decorations ORDER BY created DESC")->queryColumn();
    }

    protected function getIdsCacheDependency()
    {
        return new CDbCacheDependency("SELECT COUNT(*) FROM cook__decorations");
    }

    protected function populatePhotos($ids)
    {
        $criteria = new CDbCriteria(array(
            'with' => array(
                'photo' => array(
                    'with' => array('author'),
                ),
            ),
            'order' => new CDbExpression('FIELD(t.photo_id, ' . implode(',', $ids) . ')')
        ));
        $criteria->addInCondition('t.photo_id', $ids);
        $models = CookDecoration::model()->findAll($criteria);
        return array_map(array($this, 'populatePhoto'), $models);
    }

    protected function populatePhoto($model)
    {
        return array(
            'id' => $model->photo_id,
            'title' => $model->title,
            'description' => $model->description,
            'src' => $model->photo->getPreviewUrl(804, null, Image::WIDTH),
            'date' => HDate::GetFormattedTime($model->created),
            'user' => array(
                'id' => $model->photo->author->id,
                'firstName' => $model->photo->author->first_name,
                'lastName' => $model->photo->author->last_name,
                'gender' => $model->photo->author->gender,
                'ava' => $model->photo->author->getAva('small'),
                'url' => $model->photo->author->url,
            ),
        );
    }
}