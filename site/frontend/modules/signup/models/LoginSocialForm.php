<?php
/**
 * @author Никита
 * @date 15/02/16
 */

namespace site\frontend\modules\signup\models;


use site\frontend\modules\signup\components\SocialUserIdentity;

class LoginSocialForm extends \CFormModel
{
    public $userId;

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
            $model->user_id = $this->userId;
            $model->save();
        }
        $identity = new SocialUserIdentity($socialService['name'], $socialService['id']);
        if ($identity->authenticate()) {
            return \Yii::app()->user->login($identity);
        }
        return false;
    }
}
