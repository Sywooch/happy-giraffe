<?php
/**
 * Author: alexk984
 * Date: 10.04.12
 */
class Favourites extends EMongoDocument
{
    const BLOCK_SIMPLE = 1;
    const BLOCK_INTERESTING = 2;
    const BLOCK_BLOGS = 3;
    const BLOCK_THEME = 4;
    const BLOCK_VIDEO = 5;

    public $block;
    public $entity;
    public $entity_id;
    public $created;
    public $param;

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getCollectionName()
    {
        return 'favourites';
    }

    public function beforeSave()
    {
        if ($this->isNewRecord)
            $this->created = time();
        return parent::beforeSave();
    }

    public static function toggle($model, $block, $param)
    {
        $block = (int)$block;
        $criteria = new EMongoCriteria;
        $criteria->entity('==', get_class($model));
        $criteria->entity_id('==', (int)$model->primaryKey);
        $criteria->block('==', $block);

        $fav = self::model()->find($criteria);
        if ($fav !== null) {
            if ($fav->block == $block) {
                return $fav->delete();
            } else {
                $fav->block = $block;
                return $fav->save();
            }
        } else {
            $fav = new Favourites();
            $fav->entity = get_class($model);
            $fav->entity_id = (int)$model->primaryKey;
            $fav->block = $block;
            if (!empty($param))
                $fav->param = (int)$param;

            return $fav->save();
        }
    }

    public static function inFavourites($model, $index)
    {
        $criteria = new EMongoCriteria;
        $criteria->entity('==', get_class($model));
        $criteria->entity_id('==', (int)$model->primaryKey);
        $criteria->block('==', (int)$index);

        $fav = self::model()->find($criteria);
        return $fav !== null;
    }

    public static function getIdList($index, $limit = null, $random = false, $param = null)
    {
        $criteria = new EMongoCriteria;
        $criteria->block('==', (int)$index);
        if (!$random)
            $criteria->sort('created', EMongoCriteria::SORT_DESC);
        else
            $criteria->sort('created', EMongoCriteria::SORT_DESC);
        if ($limit !== null)
            $criteria->limit($limit);
        if ($param !== null)
            $criteria->param('==', $param);

        $models = self::model()->findAll($criteria);
        $ids = array();
        foreach($models as $model)
            $ids [] = $model->entity_id;

        return $ids;
    }

    public static function updateCreatedTime()
    {
        $models = Favourites::model()->findAll();
        foreach($models as $model){
            $model->created = time();
            $model->save();
        }
    }

    protected function afterSave()
    {
        parent::afterSave();

        if ($this->isNewRecord && $this->block == self::BLOCK_VIDEO) {
            Yii::app()->cache->set('activityLastUpdated', time());
        }
    }
}