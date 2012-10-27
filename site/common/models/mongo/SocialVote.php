<?php
/**
 * Author: choo
 * Date: 22.05.2012
 */
class SocialVote extends EMongoDocument
{
    public $entity;
    public $entity_id;
    public $service_key;
    public $service_id;

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getCollectionName()
    {
        return 'social_votes';
    }

    public function indexes()
    {
        return array(
            'index' => array(

                'key' => array(
                    'entity' => EMongoCriteria::SORT_ASC,
                    'entity_id' => EMongoCriteria::SORT_ASC,
                    'service_key' => EMongoCriteria::SORT_ASC,
                    'service_id' => EMongoCriteria::SORT_ASC,
                ),

                'unique' => true,
            ),
        );
    }
}
