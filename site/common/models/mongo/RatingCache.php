<?php
class RatingCache extends EMongoDocument
{
    public $entity_id;
    public $entity_name;
    public $ratings;
    public $created_date;

    public function getCollectionName()
    {
        return 'ratings';
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function rules()
    {
        return array(
            array('entity_id, entity_name, ratings, created_date', 'safe'),
        );
    }

    /**
     * @static
     * @param CActiveRecord $entity
     * @param array $socials
     * @param string $url
     * @return RatingCache
     */
    public static function checkCache($entity, $socials, $url)
    {
        $entity_id = (int)$entity->primaryKey;
        $entity_name = get_class($entity);
        $model = RatingCache::findByEntity($entity);
        if(!$model)
        {
            $keys = array();
            foreach(array_keys($socials) as $social_key)
                $keys[$social_key] = Rating::countByEntity($entity, $social_key);
            $model = new RatingCache;
            $model->entity_id = $entity_id;
            $model->entity_name = $entity_name;
            $model->ratings = $keys;
            $model->created_date = time();
            $model->save();
            self::updateCache($entity, $url);
        }
        return $model;
    }


    /**
     * @static
     * @param CActiveRecord $entity
     * @param string $url
     * @return bool
     */
    public static function saveByEntity($entity, $social_key, $count)
    {
        $model = RatingCache::findByEntity($entity);
        if(!$model)
            return false;
        $model->ratings[$social_key] = $count;
        $model->save();
    }

    public static function findByEntity($entity)
    {
        $entity_id = (int)$entity->primaryKey;
        $entity_name = get_class($entity);

        $criteria = new EMongoCriteria;
        $criteria->entity_id('==', $entity_id);
        $criteria->entity_name('==', $entity_name);
        $model = RatingCache::model()->find($criteria);
        if($model)
            return $model;
        return false;
    }
}
