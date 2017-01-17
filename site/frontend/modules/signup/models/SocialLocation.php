<?php
/**
 * @author Никита
 * @date 17/01/17
 */

namespace site\frontend\modules\signup\models;


class SocialLocation extends \EMongoDocument
{
    public $service;
    public $serviceId;
    public $data;

    public function getCollectionName()
    {
        return 'social_location';
    }
    
    public function rules()
    {
        return [
            ['service, serviceId, data', 'safe'], 
        ];
    }
}