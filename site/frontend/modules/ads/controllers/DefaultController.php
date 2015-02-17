<?php
/**
 * @author Никита
 * @date 04/02/15
 */

namespace site\frontend\modules\ads\controllers;


use site\frontend\modules\ads\components\renderers\BigPostRenderer;
use site\frontend\modules\posts\models\Content;

class DefaultController extends \HController
{
    public function actionTest()
    {
        $post = Content::model()->findByPk(11);
        $renderer = new BigPostRenderer($post, 'smallPost');
        echo $renderer->render();
    }
}