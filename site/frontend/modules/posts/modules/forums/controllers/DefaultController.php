<?php
/**
 * @author Никита
 * @date 27/10/15
 */

namespace site\frontend\modules\posts\modules\forums\controllers;


use site\frontend\modules\posts\models\Content;
use site\frontend\modules\posts\models\Label;
use site\frontend\modules\posts\modules\forums\components\TagHelper;
use site\frontend\modules\posts\modules\forums\widgets\feed\FeedWidget;

class DefaultController extends \LiteController
{
    public $litePackage = 'forum-homepage';

    public function actionIndex()
    {
        $this->render('index');
    }
}