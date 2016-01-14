<?php

namespace site\frontend\modules\som\modules\idea\controllers;

use site\frontend\modules\som\modules\idea\models\Idea;
use site\frontend\modules\photo\models\api\Attach;
use site\frontend\modules\photo\models\api\Collection;


class DefaultController extends \HController
{
    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionMyIdeas($id)
    {
        //why?
        $this->render('my');
    }
}