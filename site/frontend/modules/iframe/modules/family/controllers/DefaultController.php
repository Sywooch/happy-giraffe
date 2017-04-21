<?php

namespace site\frontend\modules\iframe\modules\family\controllers;

use site\frontend\modules\iframe\modules\family\models\Family;
use site\frontend\modules\iframe\modules\family\models\FamilyMember;

class DefaultController extends \LiteController
{
    public $litePackage = 'family-iframe';
    public $layout = '/layouts/family';

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

        /** @var \site\frontend\modules\iframe\modules\family\models\Family $family */
        $family = Family::model()->with([
            'members'=>[
                'joinType'=>'INNER JOIN',
                'condition'=>'members.type="child"',
            ]
        ])->hasMember($userId)->find();

        if ($family !== null) {
            $this->render('index', compact('family',  'userId'));
        } elseif (\Yii::app()->user->id == $userId) {
            $this->render('empty', compact('userId'));
        } else {
            throw new \CHttpException(404);
        }
	}

    public function actionFill($userId)
    {
        if (\Yii::app()->user->id != $userId) {
            throw new \CHttpException(404);
        }

        $this->render('fill');
    }
}