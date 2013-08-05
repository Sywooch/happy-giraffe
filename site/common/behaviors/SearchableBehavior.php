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
                    'text' => strip_tags($this->owner->content->text),
                    'timestamp' => strtotime($this->owner->created),
                );
            case 'photo':
                return array(
                    'title' => $this->owner->title,
                    'timestamp' => strtotime($this->owner->created),
                );
        }
    }

    protected function getVariables()
    {
        Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');
        Yii::import('site.common.models.mongo.PageView');
        Yii::import('site.common.models.mongo.Rating');

        return array(
            Rating::model()->countByEntity($this->owner),
            PageView::model()->viewsByPath($this->owner->url),
        );
    }

    protected function getCategories()
    {
        return array(
            'entity' => $this->owner->entity,
        );
    }

    protected function addSaveToQueue()
    {
        $data = array(
            'modelName' => get_class($this->owner),
            'modelId' => $this->owner->id,
            'action' => 'save',
        );
        Yii::app()->gearman->client()->doBackground('indexden', serialize($data));
    }

    protected function addDeleteToQueue()
    {
        $data = array(
            'modelName' => get_class($this->owner),
            'modelId' => $this->owner->id,
            'action' => 'delete',
        );
        Yii::app()->gearman->client()->doBackground('indexden', serialize($data));
    }

    public function attach($owner)
    {
        parent::attach($owner);

        $owner->attachEventHandler('onAfterSave', array($this, 'addSaveToQueue'));
        $owner->attachEventHandler('onAfterDelete', array($this, 'addDeleteToQueue'));
    }

    public function detach($owner)
    {
        parent::detach($owner);

        $owner->detachEventHandler('onAfterSave', array($this, 'addSaveToQueue'));
        $owner->detachEventHandler('onAfterDelete', array($this, 'addDeleteToQueue'));
    }
}