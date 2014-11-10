<?php
/**
 * @author Никита
 * @date 23/10/14
 */

namespace site\frontend\modules\family\controllers;


use site\frontend\modules\family\models\Family;
use site\frontend\modules\family\models\FamilyMember;

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

    public function actionGet($id, $public = true)
    {
        $family = Family::getByUserId($id, false);
        $this->success = $family !== null;
        if ($family !== null) {
            $this->data = $family->toJSON();
            $this->data['members'] = $family->getMembers(null, false);
        }
    }

    public function actionCreateFamily()
    {
        if (! \Yii::app()->user->checkAccess('createFamily')) {
            throw new \CHttpException(403, 'Недостаточно прав');
        }

        $family = Family::createFamily(\Yii::app()->user->id);
        $this->success = $family !== null;
        if ($family !== null) {
            $this->data = $family;
        }
    }

    public function actionCreateMember(array $attributes)
    {
        if (! \Yii::app()->user->checkAccess('createFamilyMember')) {
            throw new \CHttpException(403, 'Недостаточно прав');
        }

        $family = Family::getByUserId(\Yii::app()->user->id, false);
        if ($family === null) {
            throw new \CException('У авторизованного пользователя нет семьи');
        }

        $modelClass = FamilyMember::getClassName($attributes['type']);
        /** @var \site\frontend\modules\family\models\FamilyMember $model */
        $model = new $modelClass();
        $model->familyId = $family->id;
        $model->attributes = $attributes;
        $this->success = $model->save();
        $this->data = $model->hasErrors() ? array(
            'errors' => $model->getErrors(),
        ) : $model;
    }
} 