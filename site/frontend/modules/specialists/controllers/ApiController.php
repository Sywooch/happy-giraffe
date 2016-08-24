<?php

namespace site\frontend\modules\specialists\controllers;
use site\frontend\modules\specialists\components\SpecialistsManager;

/**
 * @author Никита
 * @date 22/08/16
 */
class ApiController extends \site\frontend\components\api\ApiController
{
    public function actions()
    {
        return \CMap::mergeArray(parent::actions(), array(
            'edit' => array(
                'class' => 'site\frontend\components\api\EditAction',
                'modelName' => '\site\frontend\modules\specialists\models\SpecialistProfile',
                'checkAccess' => 'editSpecialistProfileData',
            ),
        ));
    }
    
    public function actionMakeSpecialist($userId = null, array $specializations = [])
    {
        if ($userId === null) {
            $userId = \Yii::app()->user->id;
        }
        $this->success = SpecialistsManager::makeSpecialist($userId, $specializations);
    }
}