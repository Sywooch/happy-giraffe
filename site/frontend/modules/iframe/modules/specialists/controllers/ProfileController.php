<?php
/**
 * @author Никита
 * @date 30/08/16
 */

namespace site\frontend\modules\iframe\modules\specialists\controllers;


use site\frontend\modules\iframe\components\QaController;
use site\frontend\modules\som\modules\qa\models\QaAnswer;
use site\frontend\modules\specialists\modules\pediatrician\components\QaManager;
use site\frontend\modules\iframe\components\user\User;

class ProfileController extends QaController
{
    public $litePackage = 'pediatrician-iframe';
    public $layout = '/../../../views/layouts/profile';
    public $user;

    public function actionIndex($userId)
    {
        $this->loadUser($userId);
        $dp = QaManager::getAnswersDp($userId, TRUE);
        $dp->pagination->pageVar = 'page';
        $this->render('index', compact('dp'));
    }

    public function actionInfo($userId)
    {
        $this->loadUser($userId);
        $this->render('info');
    }

    protected function loadUser($userId)
    {
        $this->user = User::model()->findByPk($userId);
        if (! $this->user) {
            throw new \CHttpException(404);
        }
    }

}