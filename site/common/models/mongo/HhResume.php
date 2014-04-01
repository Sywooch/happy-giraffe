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
    // Информация о резюме
    public $rawResponse;
    public $firstName;
    public $middleName;
    public $lastName;
    public $salaryAmount;
    public $salaryCurrency;
    public $city;
    public $age;
    public $contacts = array();

    // Технические данные
    public $query; //запрос, по которому было найдено резюме
    public $created; //дата получения резюме
    public $parsed = false; //дата парсинга
    public $send = false; //дата отправки письма с приглашением

    public function getCollectionName()
    {
        return 'hh_resumes';
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    protected function beforeSave()
    {
        if ($this->getIsNewRecord())
            $this->created = time();
        return parent::beforeSave();
    }
}