<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 10/17/13
 * Time: 10:55 AM
 * To change this template use File | Settings | File Templates.
 */

class ClubPopular extends EMongoDocument
{
    public $date;
    public $clubId;
    public $contents = array();

    public function getCollectionName()
    {
        return 'club_popular';
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}