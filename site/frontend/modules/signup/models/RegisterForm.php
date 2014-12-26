<?php

namespace site\frontend\modules\signup\models;

/**
 * @author Никита
 * @date 12/12/14
 */

class RegisterForm extends \CFormModel
{
    const GENDER_FEMALE = 0;
    const GENDER_MALE = 1;

    public $firstName;
    public $lastName;
    public $birthday;
    public $gender;
    public $email;
    public $password;
    public $avatarSrc;
    
    public $user;

    public function rules()
    {
        return array(
            array('firstName, lastName, birthday, gender, email, password', 'required'),
            array('firstName', 'length', 'max' => 50),
            array('lastName', 'length', 'max' => 50),
            array('email', 'email'),
            array('email', 'unique', 'className' => 'User', 'caseSensitive' => false, 'criteria' => array('condition' => 'deleted = 0')),
            array('birthday', 'date', 'format' => 'yyyy-M-d'),
            array('gender', 'in', 'range' => array(self::GENDER_FEMALE, self::GENDER_MALE)),
            array('password', 'length', 'min' => 6, 'max' => 15),
            array('avatarSrc', 'safe'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'firstName' => 'Имя',
            'lastName' => 'Фамилия',
            'birthday' => 'Дата рождения',
            'birthdayD' => 'День',
            'birthdayM' => 'Месяц',
            'birthdayY' => 'Год',
            'gender' => 'Пол',
            'email' => 'E-mail',
            'password' => 'Пароль',
        );
    }

    public function save()
    {
        $transaction = \Yii::app()->db->beginTransaction();
        try {
            $this->user = new \User();
            $this->user->first_name = $this->firstName;
            $this->user->last_name = $this->lastName;
            $this->user->birthday = $this->birthday;
            $this->user->gender = $this->gender;
            $this->user->email = $this->email;
            $this->user->password = \User::hashPassword($this->password);
            $this->user->status = \User::STATUS_ACTIVE;
            if ($this->user->save()) {
                $this->afterSave();
                $transaction->commit();
                return true;
            } else {
                $transaction->rollback();
            }
        } catch (\Exception $e) {
            $transaction->rollback();
            throw $e;
        }
        return false;
    }

    protected function afterSave()
    {
        if (($socialService = \Yii::app()->user->getState('socialService')) !== null) {
            $service = new \UserSocialService();
            $service->service = $socialService['name'];
            $service->service_id = $socialService['id'];
            $service->user_id = $this->user->id;
            $service->save();
            \Yii::app()->user->setState('socialService', null);
        }

        if ($this->avatarSrc) {
            $photo = \AlbumPhoto::createByUrl($this->avatarSrc, $this->user->id);
            if ($photo) {
                \UserAvatar::createUserAvatar($this->user->id, $photo->id, 0, 0, $photo->width, $photo->height);
            }
        }

        $userAddress = new \UserAddress();
        $userAddress->user_id = $this->user->id;
        $userAddress->save();

        //рубрика для блога
        $rubric = new \CommunityRubric;
        $rubric->title = 'Обо всём';
        $rubric->user_id = $this->user->id;
        $rubric->save();

        \Yii::import('site.frontend.modules.myGiraffe.models.*');
        \ViewedPost::getInstance($this->user->id);

        \Friend::model()->addCommentatorAsFriend($this->user->id);

        //create some tables
        \Yii::app()->db->createCommand()->insert(\UserPriority::model()->tableName(), array('user_id' => $this->user->id));
        \Yii::app()->db->createCommand()->insert(\UserScores::model()->tableName(), array('user_id' => $this->user->id));
    }
} 