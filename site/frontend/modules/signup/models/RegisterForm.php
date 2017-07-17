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
    const GENDER_UNDEFINED = 2;

    public $firstName;
    public $lastName;
    public $birthday;
    public $gender;
    public $email;
    public $password;
    public $avatarSrc;

    public $country_id;
    public $city_id;

    /**
     * @var \User
     */
    public $user;
    
    public function init()
    {
        $this->user = new \User();
        parent::init();
    }

    public function rules()
    {
        return array(
            array('email', 'required'),
            array('password', 'required', 'except' => 'social'),
            array('firstName', 'length', 'max' => 50),
            array('lastName', 'length', 'max' => 50),
            array('email', 'email'),
            array('email', 'unique', 'className' => 'User', 'caseSensitive' => false, 'criteria' => array('scopes' => array('active'))),
            array('birthday', 'date', 'format' => 'yyyy-M-d'),
            array('gender', 'in', 'range' => array(self::GENDER_FEMALE, self::GENDER_MALE)),
            array('password', 'length', 'min' => 6, 'max' => 15),
            array('avatarSrc', 'safe'),

            array('country_id', 'exist', 'className' => 'GeoCountry', 'attributeName' => 'id'),
            array('city_id', 'exist', 'className' => 'GeoCity', 'attributeName' => 'id'),
            array('country_id', 'default', 'value' => null),
            array('city_id', 'default', 'value' => null),
            array('gender', 'default', 'value' => self::GENDER_UNDEFINED),
        );
    }

    public function attributeLabels()
    {
        return array(
            'firstName' => 'Имя',
            'lastName' => 'Фамилия',
            'middleName' => 'Отчество',
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
        $this->user->first_name = $this->firstName;
        $this->user->last_name = $this->lastName;
        $this->user->birthday = $this->birthday;
        $this->user->gender = $this->gender;
        $this->user->email = $this->email;
        $this->user->password = \User::hashPassword($this->password);
        $this->user->status = \User::STATUS_ACTIVE;

        $transaction = \Yii::app()->db->beginTransaction();
        try {
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
        $userAddress->attributes = $this->attributes;
        if ($userAddress->city !== null) {
            $userAddress->region_id = $userAddress->city->region_id;
        }
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