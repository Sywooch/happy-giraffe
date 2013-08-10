<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 7/30/13
 * Time: 5:06 PM
 * To change this template use File | Settings | File Templates.
 */

class AlbumPhotoCollection extends PhotoCollection
{
    public $albumId;

    public function generateIds()
    {
        return Yii::app()->db->createCommand("SELECT id FROM album__photos WHERE album_id = :album_id")->queryColumn(array(':album_id' => $this->albumId));
    }

    protected function getIdsCacheDependency()
    {
        $dependency = new CDbCacheDependency("SELECT COUNT(*) FROM album__photos WHERE album_id = :album_id");
        $dependency->params = array(':album_id' => $this->albumId);
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

    public function getUrl()
    {
        $album = Album::model()->findByPk($this->albumId);
        return $album->url;
    }
}