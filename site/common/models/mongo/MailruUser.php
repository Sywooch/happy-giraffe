<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 10/17/13
 * Time: 10:55 AM
 * To change this template use File | Settings | File Templates.
 */

class MailruUser extends EMongoDocument
{
    const LIST_PlANNING = 0;
    const LIST_PREGNANCY = 1;
    const LIST_CHILD = 2;

    public $firstName;
    public $lastName;
    public $gender;
    public $url;
    public $email;
    public $geo;
    public $age;
    public $pregnancyWeek;
    public $children = array();
    public $list;

    public function getCollectionName()
    {
        return 'mailru_users';
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}