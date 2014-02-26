<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 25/02/14
 * Time: 16:46
 * To change this template use File | Settings | File Templates.
 */

class RegisterFormStep2 extends User
{
    public function register()
    {
        $password = self::createPassword(8);
        $this->password = self::hashPassword($password);
        $this->activation_code = $this->createActivationCode();
        if ($this->save()) {
            $this->prepare();
            Yii::app()->email->send($this, 'confirmEmail', array(
                'password' => $password,
                'email' => $this->email,
                'first_name' => $this->first_name,
                'activation_url' => Yii::app()->createAbsoluteUrl('/signup/register/confirm', array('activationCode' => $this->activation_code)),
            ));
            return true;
        }
        return false;
    }

    protected function createActivationCode()
    {
        return sha1(mt_rand(10000, 99999) . time() . $this->email);
    }

    protected function prepare()
    {
        //рубрика для блога
        $rubric = new CommunityRubric;
        $rubric->title = 'Обо всём';
        $rubric->user_id = $this->id;
        $rubric->save();

        Yii::import('site.frontend.modules.myGiraffe.models.*');
        ViewedPost::getInstance($this->id);

        Friend::model()->addCommentatorAsFriend($this->id);

        //create some tables
        Yii::app()->db->createCommand()->insert(UserPriority::model()->tableName(), array('user_id' => $this->id));
        Yii::app()->db->createCommand()->insert(UserScores::model()->tableName(), array('user_id' => $this->id));
        Yii::app()->db->createCommand()->insert(UserAddress::model()->tableName(), array('user_id' => $this->id));
    }
}