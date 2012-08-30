<?php

class CommentsLimit extends EMongoDocument
{
    public $entity;
    public $entity_id;
    public $limit;

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getCollectionName()
    {
        return 'comments_limit';
    }

    /**
     * @static
     * @param string $entity
     * @param int $entity_id
     * @param int $limit
     * @return int
     */
    public static function getLimit($entity, $entity_id, $limit, $limit_max = null)
    {
        $criteria = new EMongoCriteria;
        $criteria->entity('==', $entity);
        $criteria->entity_id('==', (int)$entity_id);
        $model = self::model()->find($criteria);
        if ($model === null) {
            $model = new CommentsLimit();
            $model->entity = $entity;
            $model->entity_id = (int)$entity_id;
            if (empty($limit_max))
                $model->limit = rand(round($limit - $limit/8), round($limit + $limit/8));
            else
                $model->limit = rand($limit, $limit_max);
            $model->save();
        }

        return $model->limit;
    }
}
