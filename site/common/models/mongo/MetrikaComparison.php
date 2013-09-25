<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 9/25/13
 * Time: 12:09 PM
 * To change this template use File | Settings | File Templates.
 */

class MetrikaComparison extends EMongoDocument
{
    public $url;
    public $title;
    public $dynamic;
    public $dynamicText;

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getCollectionName()
    {
        return 'metrika_comparison';
    }
}