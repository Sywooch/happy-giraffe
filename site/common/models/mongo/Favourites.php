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
    const WEEKLY_MAIL = 6;
    const BLOCK_SOCIAL_NETWORKS = 7;

    public $block;
    public $entity;
    public $entity_id;
    public $created;
    public $date;
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

    /**
     * Добавить в список если нет или удалить если есть в списке
     *
     * @param $model CActiveRecord
     * @param $block int
     * @param $param null
     * @return bool
     */
    public static function toggle($model, $block, $param = null)
    {
        $block = (int)$block;
        $criteria = new EMongoCriteria;
        $criteria->entity('==', get_class($model));
        $criteria->entity_id('==', (int)$model->primaryKey);
        $criteria->block('==', $block);

        $fav = self::model()->find($criteria);
        if ($fav !== null) {
            return $fav->delete();
        } else {
            $fav = new Favourites();
            $fav->entity = get_class($model);
            $fav->entity_id = (int)$model->primaryKey;
            $fav->date = date("Y-m-d", strtotime('+ 1 day'));
            $fav->block = $block;
            if (!empty($param))
                $fav->param = (int)$param;

            return $fav->save();
        }
    }

    /**
     * Находиться элемент в списке
     * @param $model CActiveRecord
     * @param $block int
     * @return bool
     */
    public static function inFavourites($model, $block)
    {
        $criteria = new EMongoCriteria;
        $criteria->entity('==', get_class($model));
        $criteria->entity_id('==', (int)$model->primaryKey);
        $criteria->block('==', (int)$block);

        $fav = self::model()->find($criteria);
        return $fav !== null;
    }

    public static function getIdList($index, $limit = null, $param = null)
    {
        $criteria = new EMongoCriteria;
        $criteria->block('==', (int)$index);
        $criteria->sort('created', EMongoCriteria::SORT_DESC);
        if ($limit !== null)
            $criteria->limit($limit);
        if ($param !== null)
            $criteria->param('==', $param);

        $models = self::model()->findAll($criteria);
        $ids = array();
        foreach ($models as $model)
            $ids [] = $model->entity_id;

        return $ids;
    }

    /**
     * Возвращает список id постов для комментирования
     *
     * @param $index
     * @return array
     */
    public static function getListForCommentators($index)
    {
        $criteria = new EMongoCriteria;
        $criteria->block('==', (int)$index);
        $criteria->sort('created', EMongoCriteria::SORT_DESC);
        $criteria->limit(self::getLimit($index));
        #TODO добавить ограничения чтобы не комментировали те, которые уже неактуальны, например в email-рассылке

        $models = self::model()->findAll($criteria);
        $ids = array();
        foreach ($models as $model)
            $ids [] = $model->entity_id;

        return $ids;
    }

    /**
     * Возвращает лимит постов для комментирования
     *
     * @param $index тип блока
     * @return int
     */
    public static function getLimit($index)
    {
        switch ($index) {
            case self::BLOCK_BLOGS:
                return 12;
            case self::BLOCK_INTERESTING:
                return 4;
            case self::BLOCK_SOCIAL_NETWORKS:
                return 10;
            case self::WEEKLY_MAIL:
                return 6;
        }

        return 1;
    }



    public static function getIdListForView($index, $limit = null, $param = null)
    {
        $criteria = new EMongoCriteria;
        $criteria->block('==', (int)$index);
        $criteria->created('<', strtotime(date("Y-m-d", strtotime('-1 day')) . ' 23:59:59'));
        $criteria->sort('created', EMongoCriteria::SORT_DESC);
        if ($limit !== null)
            $criteria->limit($limit);
        if ($param !== null)
            $criteria->param('==', $param);

        $models = self::model()->findAll($criteria);
        $ids = array();
        foreach ($models as $model)
            $ids [] = $model->entity_id;

        return $ids;
    }

    public function getWeekPosts()
    {
        $criteria = new EMongoCriteria;
        $criteria->block('==', self::WEEKLY_MAIL);
        $criteria->created('>', strtotime('-6 days'));
        $criteria->setSort(array('created' => EMongoCriteria::SORT_DESC));
        $mongo_models = self::model()->findAll($criteria);
        $ids = array();
        foreach ($mongo_models as $model)
            $ids [] = $model->entity_id;

        if (empty($ids))
            return array();

        $criteria = new CDbCriteria;
        $criteria->compare('t.id', $ids);
        $models = CommunityContent::model()->full()->findAll($criteria);
        $result = array();
        for ($i = 0; $i < count($ids); $i++) {
            foreach ($models as $model)
                if ($model->id == $ids[$i])
                    $result [] = $model;
        }

        return $result;
    }
}