<?php

namespace site\frontend\modules\users\controllers;
use site\frontend\modules\users\models\ChangeEmailForm;
use site\frontend\modules\users\models\ChangePasswordForm;
use site\frontend\modules\users\models\User;

/**
 * Description of ApiController
 *
 * @author Кирилл
 */
class ApiController extends \site\frontend\components\api\ApiController
{

    public function actions()
    {
        return \CMap::mergeArray(parent::actions(), array(
            'get' => 'site\frontend\components\api\PackAction',
        ));
    }

    public function packGet($id, $avatarSize = false)
    {
        $user = User::model()->findByPk($id);
        if (!$user)
            throw new \CHttpException(404, 'Пользователь ' . $id . ' не найден');
        $this->success = true;
        $this->data = $user->toJSON();
        if ($avatarSize)
            $this->data['avatarUrl'] = $user->getAvatarUrl($avatarSize);
    }

    public function actionGetCurrentUser()
    {
        $user = User::model()->findByPk(\Yii::app()->user->id);
        $data = $user->toJSON();
        $data['email'] = $user->email;
        $data['address'] = $user->address->toJSON();
        $data['socialServices'] = $user->userSocialServices;
        $data['subscription'] = $user->mail_subs === null ? 1 : $user->mail_subs->weekly_news == 1 ? 1 : 0;
        $this->success = true;
        $this->data = $data;
    }

    public function actionUpdate($id, array $attributes)
    {
        /** @var \site\frontend\modules\users\models\User $user */
        $user = $this->getModel('\site\frontend\modules\users\models\User', $id, 'editSettings');
        $user->attributes = $attributes;
        $this->success = $user->save();
        $this->data = ($this->success) ? $user : array(
            'errors' => $user->errors,
        );
    }

    public function actionChangePassword($id, $password)
    {
        /** @var \site\frontend\modules\users\models\User $user */
        $user = $this->getModel('\site\frontend\modules\users\models\User', $id, 'editSettings');
        $form = new ChangePasswordForm($user, $password);
        $this->success = $form->validate() && $form->save();
        $this->data = ($this->success) ? $user : array(
            'errors' => $form->errors,
        );
    }

    public function actionChangeEmail($id, $email)
    {
        /** @var \site\frontend\modules\users\models\User $user */
        $user = $this->getModel('\site\frontend\modules\users\models\User', $id, 'editSettings');
        $form = new ChangeEmailForm($user, $email);
        $this->success = $form->validate() && $form->save();
        $this->data = ($this->success) ? $user : array(
            'errors' => $form->errors,
        );
    }

    public function actionChangeLocation($id, $countryId = null, $regionId = null, $cityId = null)
    {
        /** @var \site\frontend\modules\users\models\User $user */
        $user = $this->getModel('\site\frontend\modules\users\models\User', $id, 'editSettings');
        if ($cityId) {
            $user->address->city_id = $cityId;
        }
        if ($regionId) {
            $user->address->region_id = $regionId;
        }
        if ($countryId) {
            $user->address->country_id = $countryId;
        }
        $this->success = $user->address->save();
        $this->data = ($this->success) ? $user : array(
            'errors' => $user->address->errors,
        );
    }

    public function actionMailSubscription($id, $value)
    {
        /** @var \site\frontend\modules\users\models\User $user */
        $user = $this->getModel('\site\frontend\modules\users\models\User', $id, 'editSettings');
        $user->getMailSubs()->weekly_news = $value;
        $this->success = $user->getMailSubs()->save();
    }

    public function actionRemove($id)
    {
        /** @var \site\frontend\modules\users\models\User $user */
        $user = $this->getModel('\site\frontend\modules\users\models\User', $id, 'editSettings');
        $user->deleted = 1;
        $this->success = $user->save(false, array('deleted'));
        if ($this->success) {
            \Yii::app()->user->logout();
        }
    }
}

?>
