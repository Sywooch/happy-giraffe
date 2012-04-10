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

    public $block;
    public $entity;
    public $entity_id;

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getCollectionName()
    {
        return 'favourites';
    }

    public static function toggle($model, $block)
    {
        $block = (int)$block;
        $criteria = new EMongoCriteria;
        $criteria->entity('==', get_class($model));
        $criteria->entity_id('==', (int)$model->primaryKey);
        $criteria->block('==', $block);

        $fav = self::model()->find($criteria);
        if ($fav) {
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
            return $fav->save();
        }
    }

    public static function inFavourites($model, $index){
        $criteria = new EMongoCriteria;
        $criteria->entity('==', get_class($model));
        $criteria->entity_id('==', (int)$model->primaryKey);
        $criteria->block('==', (int)$index);

        $fav = self::model()->find($criteria);
        return $fav !== null;
    }

    public static function getIdList($index)
    {
        $criteria = new EMongoCriteria;
        $criteria->block('==', (int)$index);

        $models = self::model()->findAll($criteria);
        $ids = array();
        foreach($models as $model)
            $ids [] = $model->entity_id;

        return $ids;
    }
}