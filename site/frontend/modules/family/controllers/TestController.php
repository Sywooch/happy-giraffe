<?php
/**
 * @author Никита
 * @date 23/10/14
 */

namespace site\frontend\modules\family\controllers;


use site\frontend\modules\family\models\Adult;
use site\frontend\modules\family\models\FamilyMember;

class TestController extends \HController
{
    public function actionFamily()
    {
        \Yii::app()->user->model->getFamily();
    }

    public function actionAddAdult($gender, $familyId)
    {
        $adult = new Adult();
        $adult->gender = $gender;
        $adult->familyId = $familyId;
        $adult->relationshipStatus = 'engaged';
        $adult->save();
    }

    public function actionChangeUser()
    {
        $user = \User::model()->findByPk(12936);
        $user->first_name = 'lolwhat' . mt_rand(1, 100);
        $user->save();
    }

    public function actionMagic()
    {
        $member = FamilyMember::model()->find();
        var_dump($member->user->firstName);
    }
} 