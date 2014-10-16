<?php

namespace site\frontend\components\api\models;

/**
 * Модель, реализующая доступ к API, согласно описанию https://happygiraffe.atlassian.net/wiki/pages/viewpage.action?pageId=2195460
 *
 * @property-read int $id Id пользователя
 * @property-read string $firstName Имя
 * @property-read string $lastName Фамилия
 * @property-read int $avatarId Id аватара
 * @property-read int $gender Пол (0 - Ж, 1 - М)
 * @property-read bool $isOnline true, если пользователь online, иначе - false
 * @property-read string $profileUrl Ссылка на профиль
 * @property-read string $avatarUrl Ссылка на аватар, запрошенного размера
 * @property-read string $publicChannel Публичный канал пользователя
 * @author Кирилл
 */
class User extends ApiModel
{

    public $api = 'users';

    /**
     * 
     * @param string $className
     * @return \site\frontend\components\api\models\User
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function attributeNames()
    {
        return array(
            'id',
            'firstName',
            'lastName',
            'avatarId',
            'gender',
            'isOnline',
            'profileUrl',
            'avatarUrl',
            'publicChannel',
        );
    }

}

?>
