<?php
/**
 * Author: alexk984
 * Date: 31.05.12
 */

class WebmasterData extends EMongoDocument
{
    public $user_id;
    public $cookie;
    public $hosts_url;
    public $host;

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getCollectionName()
    {
        return 'webmaster_data';
    }
}