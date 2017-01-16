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

    /**
     * @todo убрать, нужен только для тестов
     */
    public function actionRemove()
    {
        $family = Family::model()->hasMember(\Yii::app()->user->id)->find();
        $this->success = $family->delete();
    }

    public function actionGet($userId, $publicOnly = true)
    {
        /** @var \site\frontend\modules\family\models\Family $family */
        $family = Family::model()->hasMember($userId)->find();
        if ($family !== null) {
            $this->data = $family->toJSON();
            $this->data['members'] = $family->getMembers(null, $publicOnly);
        } else {
            $this->data = null;
        }
        $this->success = true;
    }

    public function actionCreate()
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

    /**
     * @param $userId
     */
    public function actionNeedFill($userId)
    {
        $family = Family::model()->hasMember($userId)->find();
        $this->success = $family !== null;
        if ($family !== null) {
            $members = $family->getMembers(null, false);
            $result = array();
            foreach ($members as $member) {
                if (! $member->validate()) {
                    $result = array(
                        'member' => $member->toJSON(),
                        'errors' => $member->getErrors(),
                    );
                }
            }
            $this->data = $result;
        }
    }

    public function actionCreateMember(array $attributes, $photoId = null)
    {
        /** @var \site\frontend\modules\family\models\FamilyMember $model */
        if (! \Yii::app()->user->checkAccess('createFamilyMember')) {
            throw new \CHttpException(403, 'Недостаточно прав');
        }

        $family = Family::model()->hasMember(\Yii::app()->user->id)->find();
        if ($family === null) {
            throw new \CException('У авторизованного пользователя нет семьи');
        }

        $modelClass = FamilyMember::getClassName($attributes['type']);
        /** @var \site\frontend\modules\family\models\FamilyMember $model */
        $model = new $modelClass();
        $model->familyId = $family->id;
        $model->attributes = $attributes;
        $this->saveMemberWithPhoto($model, $photoId);
    }

    public function actionUpdateMember(array $attributes, $id, $photoId = null)
    {
        $model = $this->getModel('\site\frontend\modules\family\models\FamilyMember', $id, 'updateFamilyMember');
        $model->attributes = $attributes;
        $this->saveMemberWithPhoto($model, $photoId);
    }

    protected function saveMemberWithPhoto(FamilyMember $model, $photoId)
    {
        if ($model->save()) {
            $this->success = true;
            if ($photoId !== null) {
                $model->photoCollection->attachPhotos($photoId);
            }
            $this->data = $model;
        } else {
            $this->success = false;
            $this->data = array('errors' => $model->getErrors());
        }
    }
}