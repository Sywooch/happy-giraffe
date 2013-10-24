<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 10/17/13
 * Time: 10:55 AM
 * To change this template use File | Settings | File Templates.
 */

class HhResume extends EMongoDocument
{
    public $firstName;
    public $middleName;
    public $lastName;
    public $salaryAmount;
    public $salaryCurrency;
    public $city;
    public $age;
    public $contacts = array();
    public $keyword;

    public function getCollectionName()
    {
        return 'hh_resumes';
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}