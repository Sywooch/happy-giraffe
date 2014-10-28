<?php
/**
 * @author Никита
 * @date 23/10/14
 */

namespace site\frontend\modules\family\controllers;


use site\frontend\modules\family\models\Family;

class ApiController extends \site\frontend\components\api\ApiController
{
    public function actions()
    {
        return \CMap::mergeArray(parent::actions(), array(
            'update' => array(
                'class' => 'site\frontend\components\api\EditAction',
                'modelName' => '\site\frontend\modules\family\models\Family',
                'checkAccess' => 'updateFamily',
            ),

            'updateMember' => array(
                'class' => 'site\frontend\components\api\EditAction',
                'modelName' => '\site\frontend\modules\family\models\FamilyMember',
                'checkAccess' => 'updateFamilyMember',
            ),
            'removeMember' => array(
                'class' => 'site\frontend\components\api\SoftDeleteAction',
                'modelName' => '\site\frontend\modules\family\models\FamilyMember',
                'checkAccess' => 'removeFamilyMember',
            ),
            'restoreMember' => array(
                'class' => 'site\frontend\components\api\SoftRestoreAction',
                'modelName' => '\site\frontend\modules\family\models\FamilyMember',
                'checkAccess' => 'restoreFamilyMember',
            ),
        ));
    }

    public function actionGet($userId)
    {
        $family = Family::getByUserId($userId);
        $this->success = $family !== null;
        if ($family !== null) {
            $this->data = $family;
        }
    }
} 