<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 25/04/14
 * Time: 14:19
 * To change this template use File | Settings | File Templates.
 */

class DevelopesUserIdentity extends CBaseUserIdentity
{
    const ERROR_ACCESS_DENIED = 3;
    const ERROR_USER_DOES_NOT_EXIST = 4;

    public $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    public function authenticate()
    {
        $developerId = $this->getDeveloperId();
        if (! Yii::app()->getAuthManager()->checkAccess('developersModule', $developerId)) {
            $this->errorCode = self::ERROR_ACCESS_DENIED;
            $this->errorMessage = 'Ты ещё не готов';
        } else {
            $model = User::model()->findByPk($this->userId);
            if ($model === null) {
                $this->errorCode = self::ERROR_USER_DOES_NOT_EXIST;
                $this->errorMessage = 'Такого пользователя не существует';
            } else {
                foreach ($model->attributes as $k => $v)
                    $this->setState($k, $v);
                $this->setState('developerId', $developerId);
                $this->errorCode = self::ERROR_NONE;
            }
        }
        return $this->errorCode == self::ERROR_NONE;
    }

    public function getId()
    {
        return $this->getState('id');
    }

    public function getName()
    {
        return $this->getState('first_name');
    }
    
    public function getDeveloperId()
    {
        $developerId = Yii::app()->user->getState('developerId');
        return ($developerId === null) ? Yii::app()->user->id : $developerId;
    }
}