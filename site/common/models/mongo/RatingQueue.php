<?php
/**
 * User: Alex Kireev
 * Date: 16.10.12
 */
class RatingQueue extends EMongoDocument
{
    public $entity;
    public $entity_id;
    public $social_key;
    public $time;

    public function getCollectionName()
    {
        return 'rating_queue';
    }

    /**
     * @param string $className
     * @return RatingQueue
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function add($entity, $entity_id, $social_key)
    {
        $exist = RatingQueue::model()->findByAttributes(array(
            'entity' => $entity,
            'entity_id' => (int)$entity_id,
            'social_key' => $social_key,
        ));
        if ($exist === null) {
            $exist = new RatingQueue;
            $exist->entity = $entity;
            $exist->entity_id = $entity_id;
            $exist->social_key = $social_key;
            $exist->time = time();
            $exist->save();
        }
    }
}
