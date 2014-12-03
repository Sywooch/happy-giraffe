<?php

namespace site\frontend\modules\family\controllers;

use site\frontend\modules\family\models\Family;
use site\frontend\modules\notifications\models\User;

class DefaultController extends \LiteController
{
    public $litePackage = 'family';

    public function filters()
    {
        return array(
            'accessControl - index',
        );
    }

    public function accessRules()
    {
        return array(
            array('deny',
                'users' => array('?'),
            ),
        );
    }

    public function actionIndex($userId)
	{
        $user = \User::model()->active()->findByPk($userId);
        if ($user === null) {
            throw new \CHttpException(404);
        }
        $this->owner = $user;

        /** @var \site\frontend\modules\family\models\Family $family */
        $family = Family::model()->with('members')->find(array('limit' => 1));

        die($family->id);

        if ($family !== null) {
            $this->render('index', compact('family',  'userId'));
        } elseif (\Yii::app()->user->id == $userId) {
            $this->render('empty');
        } else {
            throw new \CHttpException(404);
        }
	}

    public function actionFill()
    {
        $this->render('fill');
    }
}