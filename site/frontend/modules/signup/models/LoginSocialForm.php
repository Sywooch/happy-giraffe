<?php
/**
 * @author Никита
 * @date 15/02/16
 */

namespace site\frontend\modules\signup\models;


class LoginSocialForm extends \CFormModel
{


    public function login()
    {
        $socialService = \Yii::app()->user->getState('socialService');
        $model = \UserSocialService::model()->findByAttributes(array(
            'service' => $socialService['name'],
            'service_id' => $socialService['id'],
        ));
        if ($model === null) {
            $model = new \UserSocialService();
            $model->service = $socialService['name'];
            $model->service_id = $socialService['id'];
            $model->save();
        }
    }
}