<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 5/31/13
 * Time: 10:39 AM
 * To change this template use File | Settings | File Templates.
 */

class SearchableBehavior extends CActiveRecordBehavior
{
    public $index;

    public function save()
    {
        Yii::app()->indexden->save($this->index, $this->getDocId(), $this->getFields(), $this->getVariables(), $this->getCategories());
    }

    public function delete()
    {
        Yii::app()->indexden->delete($this->index, $this->getDocId());
    }

    protected function getDocId()
    {
        return get_class($this->owner) . '_' . $this->owner->primaryKey;
    }

    protected function getFields()
    {
        switch ($this->owner->entity) {
            case 'post':
            case 'video':
                return array(
                    'title' => $this->owner->title,
                    'text' => $this->owner->content->text,
                );
        }
    }

    protected function getVariables()
    {
        Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');
        Yii::import('site.common.models.mongo.PageView');

        switch ($this->owner->entity) {
            case 'post':
            case 'video':
                return array(
                    'rating' => $this->owner->rate,
                    'views' => PageView::model()->viewsByPath($this->owner->url),
                    'created' => strtotime($this->owner->created),
                );
        }
    }

    protected function getCategories()
    {
        return array(
            'entity' => $this->owner->entity,
        );
    }
}