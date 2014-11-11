<?php
/**
 * @author Никита
 * @date 23/10/14
 */

namespace site\frontend\modules\family\controllers;


use Aws\CloudFront\Exception\Exception;
use site\frontend\modules\family\models\Adult;
use site\frontend\modules\family\models\Family;
use site\frontend\modules\family\models\FamilyMember;

class TestController extends \HController
{
    public function actionFamily()
    {
        Family::getByUserId(\Yii::app()->user->id);

    }

    public function actionAddAdult()
    {
        $adult = new Adult();
        $adult->familyId = 10;
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
        $familyMember = FamilyMember::model()->find();
        $collection = $familyMember->photoCollection;
        $collection->attachPhotos(array(177));
    }
} 