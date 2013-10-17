<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 10/17/13
 * Time: 10:55 AM
 * To change this template use File | Settings | File Templates.
 */

class SiteEmail extends EMongoSoftDocument
{
    public function getCollectionName()
    {
        return 'site_emails';
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}