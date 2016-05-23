<?php

namespace site\frontend\modules\users\controllers;

use site\frontend\modules\users\models\ChangeEmailForm;
use site\frontend\modules\users\models\ChangePasswordForm;
use site\frontend\modules\users\models\User;
use site\frontend\modules\users\components\AvatarManager;

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
                    'checkAccess' => 'site\frontend\components\api\PackAction',
        ));
    }

    public function actionFail()
    {
        $user = User::model()->findByPk(0);
        $user->name;
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

    /**
     * метод обновления информации о пользователе
     * TODO: исправить возможность редактирования других пользователей
     * @param type $id
     * @param array $attributes
     */
    public function actionUpdate($id, array $attributes)
    {
        /** @var \site\frontend\modules\users\models\User $user */
        $user = $this->getModel('\site\frontend\modules\users\models\User', $id, 'editSettings');
        foreach($attributes AS &$at)
        {
            $at = htmlentities($at, ENT_QUOTES, 'UTF-8');
        }
        $user->attributes = $attributes;
        $this->success = $user->save();
        $this->data = ($this->success) ? $user : array(
            'errors' => $user->errors,
        );
    }

    public function actionChangePassword($id, $password, $oldPassword)
    {
        /** @var \site\frontend\modules\users\models\User $user */
        $user = $this->getModel('\site\frontend\modules\users\models\User', $id, 'editSettings');
        $form = new ChangePasswordForm($user, $password, $oldPassword);
        $this->success = $form->validate() && $form->save();
        $this->data = ($this->success) ? $user : array(
            'errors' => $form->errors,
        );
    }

    public function actionChangeEmail($id, $email, $oldPassword)
    {
        /** @var \site\frontend\modules\users\models\User $user */
        $user = $this->getModel('\site\frontend\modules\users\models\User', $id, 'editSettings');
        $form = new ChangeEmailForm($user, $email, $oldPassword);
        $this->success = $form->validate() && $form->save();
        $this->data = ($this->success) ? $user : array(
            'errors' => $form->errors,
        );
    }

    public function actionChangeLocation($id, $countryId = null, $regionId = null, $cityId = null)
    {
        /** @var \site\frontend\modules\users\models\User $user */
        $user = $this->getModel('\site\frontend\modules\users\models\User', $id, 'editSettings');
        $user->address->city_id = ($cityId === null) ? null : $cityId;
        $user->address->region_id = ($regionId === null) ? null : $regionId;
        $user->address->country_id = ($countryId === null) ? null : $countryId;
        $this->success = $user->address->save();
        $this->data = ($this->success) ? $user : array(
            'errors' => $user->address->errors,
        );
    }

    public function actionRemoveSocialService($id)
    {
        $service = $this->getModel('\UserSocialService', $id);
        if (!\Yii::app()->user->checkAccess('editSettings', array('entity' => $service->user)))
        {
            throw new \CHttpException(403, 'Недостаточно прав');
        }

        $this->success = $service->delete();
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

        //temp fix
        \UserSocialService::model()->deleteAllByAttributes(array(
            'user_id' => $id,
        ));

        $user->deleted = 1;
        $this->success = $user->save(false, array('deleted'));
        if ($this->success)
        {
            \Yii::app()->user->logout();
        }
    }

    public function actionSetAvatar($photoId, $userId, array $cropData)
    {
        $photo = $this->getModel('\site\frontend\modules\photo\models\Photo', $photoId);
        $user = $this->getModel('\site\frontend\modules\users\models\User', $userId, 'setAvatar');
        $avatarInfo = AvatarManager::setAvatar($user, $photo, $cropData);
        $this->success = $avatarInfo !== false;
        if ($this->success)
        {
            $this->data = $avatarInfo;
        }
    }

    public function actionRemoveAvatar($userId)
    {
        $user = $this->getModel('\site\frontend\modules\users\models\User', $userId, 'removeAvatar');
        $this->success = AvatarManager::removeAvatar($user);
    }

    public function actionGetAvatar($userId)
    {
        $user = $this->getModel('\site\frontend\modules\users\models\User', $userId);
        if ($user->avatarId !== null)
        {
            $crop = \Yii::app()->api->request('photo/crops', 'get', array('id' => $user->avatarId));
            $this->data = \CJSON::decode($crop);
        }
        $this->success = $user->avatarId !== null;
    }

}

?>
