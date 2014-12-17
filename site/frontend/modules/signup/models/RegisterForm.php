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
    public $birthdayD;
    public $birthdayM;
    public $birthdayY;
    public $gender;
    public $email;
    public $password;

    protected $birthday;

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
            $user = new \User();
            $user->attributes = $this->attributes;
            if ($user->save()) {
                $this->afterSave();
                $transaction->commit();
            } else {
                $transaction->rollback();
            }
        } catch (\Exception $e) {
            $transaction->rollback();
            throw $e;
        }
    }

    protected function afterSave()
    {
        //рубрика для блога
        $rubric = new \CommunityRubric;
        $rubric->title = 'Обо всём';
        $rubric->user_id = $this->id;
        $rubric->save();

        \Yii::import('site.frontend.modules.myGiraffe.models.*');
        \ViewedPost::getInstance($this->id);

        \Friend::model()->addCommentatorAsFriend($this->id);

        //create some tables
        \Yii::app()->db->createCommand()->insert(\UserPriority::model()->tableName(), array('user_id' => $this->id));
        \Yii::app()->db->createCommand()->insert(\UserScores::model()->tableName(), array('user_id' => $this->id));

        \Yii::app()->user->returnUrl = \Yii::app()->request->getUrlReferrer();
    }
} 