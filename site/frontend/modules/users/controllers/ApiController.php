<?php

namespace site\frontend\modules\users\controllers;
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

    public function actionSetAvatar($photoId, $userId, array $cropData)
    {
        if (! \Yii::app()->user->checkAccess('setAvatar', compact('userId'))) {
            throw new \CHttpException(403, 'Недостаточно прав');
        }

        $photo = $this->getModel('\site\frontend\modules\photo\models\Photo', $photoId);
        $user = $this->getModel('\site\frontend\modules\users\models\User', $userId);
        $avatarInfo = AvatarManager::setAvatar($user, $photo, $cropData);
        $this->success = $avatarInfo !== false;
        if ($this->success) {
            $this->data = $avatarInfo;
        }
    }

    public function actionRemoveAvatar($userId)
    {
        if (! \Yii::app()->user->checkAccess('removeAvatar', compact('userId'))) {
            throw new \CHttpException(403, 'Недостаточно прав');
        }

        $user = $this->getModel('\site\frontend\modules\users\models\User', $userId);
        $this->success = AvatarManager::removeAvatar($user);
    }
}

?>
