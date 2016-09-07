<?php

namespace site\frontend\modules\specialists\controllers;
use site\frontend\modules\specialists\components\SpecialistsManager;
use site\frontend\modules\specialists\models\ProfileForm;
use site\frontend\modules\specialists\models\SpecialistProfile;

/**
 * @author Никита
 * @date 22/08/16
 */
class ApiController extends \site\frontend\components\api\ApiController
{
    public function actionUpdateProfile($profileId, array $data)
    {
        $form = new ProfileForm();
        $form->initialize($profileId);
        if (! \Yii::app()->user->checkAccess('editSpecialistProfileData', ['entity' => $form->getProfile()])) {
            throw new \CHttpException(403);
        }
        $form->attributes = $data;
        $this->success = $form->validate() && $form->save();
        $this->data = [
            'form' => $form,
            'errors' => $form->errors,    
        ];
    }

    public function actionValidate(array $data)
    {
        $form = new ProfileForm();
        $form->attributes = $data;
        $form->validate();
        $this->success = true;
        $this->data = array(
            'errors' => $form->getErrors(),
        );
    }
    
    public function actionMakeSpecialist($userId = null, array $specializations = [])
    {
        if ($userId === null) {
            $userId = \Yii::app()->user->id;
        }
        $this->success = SpecialistsManager::makeSpecialist($userId, $specializations);
    }
}