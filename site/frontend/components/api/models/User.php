<?php

namespace site\frontend\components\api\models;

use site\frontend\modules\som\modules\qa\components\QaRatingManager;
/**
 * Модель, реализующая доступ к API, согласно описанию https://happygiraffe.atlassian.net/wiki/pages/viewpage.action?pageId=2195460
 *
 * @property-read int $id Id пользователя
 * @property-read string $firstName Имя
 * @property-read string $lastName Фамилия
 * @property-read string $middleName Отчество
 * @property-read string $fullName Полное имя
 * @property-read int $avatarId Id аватара
 * @property-read int $gender Пол (0 - Ж, 1 - М)
 * @property-read bool $isOnline true, если пользователь online, иначе - false
 * @property-read string $profileUrl Ссылка на профиль
 * @property-read string $avatarUrl Ссылка на аватар, запрошенного размера
 * @property-read array $avatarInfo массив с размерами аватаров
 * @property-read string $publicChannel Публичный канал пользователя
 * @author Кирилл
 */
class User extends ApiModel implements \IHToJSON
{

    public $api = 'users';

    public function getFullName()
    {
        $fullNameArr = array_map(
            function($value)
            {
                return \Str::ucFirst($value);
            },
            explode(' ', $this->fullName)
        );

        return implode(' ' , $fullNameArr);
    }

    /**
     * Формат имени для анонимного юзера
     *
     * @return string
     */
    public function getAnonName()
    {
        $strCity = $this->_getCity();

        $result = $this->firstName;

        if (!is_null($strCity)) {
            $result = $result . ', ' . $strCity;
        }

        return $result;
    }

    /**
     * @return void|string
     */
    private function _getCity()
    {
        $model = \UserAddress::model()->find('user_id=:user_id', [':user_id' => $this->id]);

        if (is_null($model->city)) {
            return;
        }

        return $model->city->name;
    }

    /**
     *
     * @param string $className
     * @return \site\frontend\components\api\models\User
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return array
     */
    public function formatedForJson()
    {
        return [
            'id' => $this->id,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'middleName' => $this->middleName,
            'fullName' => $this->fullName,
            'avatarId' => $this->avatarId,
            'gender' => $this->gender,
            'isOnline' => $this->isOnline,
            'profileUrl' => $this->profileUrl,
            'avatarUrl' => $this->avatarUrl,
            'avatarInfo' => $this->avatarInfo,
            'publicChannel' => $this->publicChannel,
            'city' => $this->_getCity(),
            'specialistInfo' => $this->specialistInfo,
            'anonName' => $this->getAnonName(),
            'rating' => (new QaRatingManager())->getViewCounters($this->id),
        ];
    }

    public function toJSON()
    {
        return $this->formatedForJson();
    }

    public function attributeNames()
    {
        return [
            'id',
            'firstName',
            'middleName',
            'lastName',
            'fullName',
            'birthday',
            'avatarId',
            'gender',
            'isOnline',
            'profileUrl',
            'avatarUrl',
            'avatarInfo',
            'publicChannel',
            'specInfo',
            'specialistInfo',
        ];
    }

    public function actionAttributes()
    {
        return [
            'insert' => false,
            'update' => false,
            'remove' => false,
            'restore' => false,
        ];
    }

}

?>
