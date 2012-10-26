<?php

class SocialVote extends EMongoDocument
{
    public $entity;
    public $entity_id;
    public $social_key;
    public $social_id;

    public function getCollectionName()
    {
        return 'social_votes';
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
