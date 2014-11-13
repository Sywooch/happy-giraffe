<?php

namespace site\frontend\modules\family\controllers;

use site\frontend\modules\family\models\Family;

class DefaultController extends \LiteController
{
    public $litePackage = 'family';

	public function actionIndex($userId)
	{
        /** @var \site\frontend\modules\family\models\Family $family */
        $family = Family::model()->with('members')->hasMember($userId)->find();
        if ($family === null) {
            throw new \CHttpException(404);
        }
        $members = $family->getMembers();


		$this->render('index', compact('family', 'members'));
	}
}