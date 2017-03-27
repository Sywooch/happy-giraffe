<?php
/**
 * @author Никита
 * @date 30/08/16
 */

namespace site\frontend\modules\specialists\controllers;


use site\frontend\modules\som\modules\qa\models\QaAnswer;
use site\frontend\modules\specialists\modules\pediatrician\components\QaManager;
use site\frontend\modules\users\models\User;

class ProfileController extends \LiteController
{
    public $layout = '//layouts/lite/new_main';
    public $litePackage = 'pediatrician_profile';
    public $user;

    public function actionIndex($userId)
    {
        $this->loadUser($userId);

        $dp = QaManager::getAnswersDp($userId, TRUE);
        $dp->pagination->pageVar = 'page';

        $stats = QaManager::getAnswerCountAndVotes($userId);

        $this->render('index', compact('dp', 'stats'));
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