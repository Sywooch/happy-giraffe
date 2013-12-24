<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 24/12/13
 * Time: 14:27
 * To change this template use File | Settings | File Templates.
 */

class Seo3 extends EMongoDocument
{
    public $url;
    public $yandex;
    public $google;

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getCollectionName()
    {
        return 'seo3';
    }
}