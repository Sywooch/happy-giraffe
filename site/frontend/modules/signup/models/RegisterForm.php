<?php

namespace site\frontend\modules\signup\models;
use site\frontend\modules\photo\models\Photo;
use site\frontend\modules\users\components\AvatarManager;

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
            array('email', 'unique', 'className' => 'User', 'caseSensitive' => false, 'criteria' => array('condition' => 'deleted = 0 AND status = :active', 'params' => array(':active' => \User::STATUS_ACTIVE))),
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
            } else {
                $transaction->rollback();
                return false;
            }
        } catch (\Exception $e) {
            $transaction->rollback();
            throw $e;
        }
        $this->createAvatar();
        $this->createSocialService();
        return true;
    }

    protected function createAvatar()
    {
        if ($this->avatarSrc) {
            $photo = new Photo();
            $photo->author_id = $this->user->id;
            $photo->original_name = pathinfo($this->avatarSrc, PATHINFO_BASENAME);
            $photo->image = file_get_contents($this->avatarSrc);
            if ($photo->save()) {
                AvatarManager::setAvatar($this->user, $photo);
            }
        }
    }

    protected function createSocialService()
    {
        if (($socialService = \Yii::app()->user->getState('socialService')) !== null) {
            $service = new \UserSocialService();
            $service->service = $socialService['name'];
            $service->service_id = $socialService['id'];
            $service->user_id = $this->user->id;
            $service->save();
            \Yii::app()->user->setState('socialService', null);
        }
    }

    protected function afterSave()
    {
        $this->createUserAddress();
        $this->createBlogRubric();
        $this->setupMyGiraffe();
        $this->createRelatedTables();
    }

    protected function createUserAddress()
    {
        $userAddress = new \UserAddress();
        $userAddress->user_id = $this->user->id;
        $userAddress->save();
    }

    protected function createBlogRubric()
    {
        $rubric = new \CommunityRubric;
        $rubric->title = 'Обо всём';
        $rubric->user_id = $this->user->id;
        $rubric->save();
    }

    protected function setupMyGiraffe()
    {
        \Yii::import('site.frontend.modules.myGiraffe.models.*');
        \ViewedPost::getInstance($this->user->id);
    }

    protected function createRelatedTables()
    {
        \Yii::app()->db->createCommand()->insert(\UserPriority::model()->tableName(), array('user_id' => $this->user->id));
        \Yii::app()->db->createCommand()->insert(\UserScores::model()->tableName(), array('user_id' => $this->user->id));
    }
} 