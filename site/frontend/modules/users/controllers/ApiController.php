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
        $user = \site\frontend\modules\users\models\User::model()->findByPk($id);
        if (!$user)
            throw new \CHttpException(404, 'Пользователь ' . $id . ' не найден');
        $this->success = true;
        $this->data = $user->toJSON();
        if ($avatarSize)
            $this->data['avatarUrl'] = $user->getAvatarUrl($avatarSize);
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
            User::clearCache();
            \Yii::app()->user->logout();
        }
    }
}

?>
