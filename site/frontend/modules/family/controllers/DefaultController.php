<?php

namespace site\frontend\modules\family\controllers;

use site\frontend\modules\family\models\Family;

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
        $this->render('empty');

        /** @var \site\frontend\modules\family\models\Family $family */
        $family = Family::model()->with('members')->hasMember($userId)->find();
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