<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 8/6/13
 * Time: 10:27 AM
 * To change this template use File | Settings | File Templates.
 */

class UserPhotoCollection extends PhotoCollection
{
    public $userId;

    public function generateIds()
    {
        return Yii::app()->db->createCommand("SELECT id FROM album__photos WHERE author_id = :userId")->queryColumn(array(':userId' => $this->userId));
    }

    protected function getIdsCacheDependency()
    {
        $dependency = new CDbCacheDependency("SELECT COUNT(*) FROM album__photos WHERE author_id = :userId");
        $dependency->params = array(':userId' => $this->userId);
        return $dependency;
    }

    protected function generateModels($ids)
    {
        $criteria = new CDbCriteria(array(
            'with' => array('author'),
            'order' => new CDbExpression('FIELD(t.id, ' . implode(',', $ids) . ')')
        ));
        $criteria->addInCondition('t.id', $ids);
        return AlbumPhoto::model()->findAll($criteria);
    }

    protected function toJSON($model)
    {
        return array(
            'id' => $model->id,
            'title' => $model->title,
            'description' => '',
            'src' => $model->getPreviewUrl(804, null, Image::WIDTH),
            'date' => HDate::GetFormattedTime($model->created),
            'user' => array(
                'id' => $model->author->id,
                'firstName' => $model->author->first_name,
                'lastName' => $model->author->last_name,
                'gender' => $model->author->gender,
                'ava' => $model->author->getAva('small'),
                'url' => $model->author->url,
            ),
        );
    }
}