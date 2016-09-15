<?php
/**
 * @author Никита
 * @date 30/08/16
 */

namespace site\frontend\modules\specialists\controllers;


use site\frontend\modules\som\modules\qa\models\QaAnswer;
use site\frontend\modules\users\models\User;

class ProfileController extends \LiteController
{
    public $litePackage = 'pediatrician';
    public $user;

    public function actionIndex($userId)
    {
        $this->loadUser($userId);
        $dp = new \CActiveDataProvider(QaAnswer::model(), [
            'criteria' => [
                'scopes' => [
                    'user' => [$userId],
                    'orderDesc',
                ],
            ],
            'pagination' => [
                'pageVar' => 'page',
            ],
        ]);
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
            throw new \CHttpException(403);
        }
    }
}