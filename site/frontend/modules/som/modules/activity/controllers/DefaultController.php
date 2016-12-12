<?php

namespace site\frontend\modules\som\modules\activity\controllers;

class DefaultController extends \LiteController
{
	public function actionIndex()
	{
	    \CommentLogger::model()->addToLog('site\frontend\modules\som\modules\activity\controllers\DefaultController', 'actionIndex()');
		$post = \site\frontend\modules\posts\models\Content::model()->findByPk(5);
        $post->addActivity();
	}
}