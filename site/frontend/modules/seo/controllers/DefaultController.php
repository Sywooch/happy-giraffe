<?php

namespace site\frontend\modules\seo\controllers;

use site\frontend\modules\seo\components\YandexWebmaster;
use site\frontend\modules\seo\components\YandexOriginalText;
use site\frontend\modules\seo\models\SeoYandexOriginalText;

class DefaultController extends \HController
{
	public function actionTest()
	{
        $original = new YandexOriginalText();
        $model = new SeoYandexOriginalText();
        $model->priority = 1;
        $original->test($model);
        echo $model->priority;
	}
}