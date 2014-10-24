<?php
/**
 * @author Никита
 * @date 23/10/14
 */

namespace site\frontend\modules\family\controllers;


use site\frontend\modules\family\models\Adult;

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
} 