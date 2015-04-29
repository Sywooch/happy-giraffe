<?php
namespace site\frontend\modules\posts\modules\onAir\controllers;
use site\frontend\modules\posts\models\Content;

/**
 * @author Никита
 * @date 27/04/15
 */

class DefaultController extends \LiteController
{
    public $litePackage = 'posts';

    public function actionIndex()
    {
        $this->render('index');
    }

    protected function getListDataProvider()
    {
        return new \CActiveDataProvider(Content::model()->orderDesc(), array(
            'pagination' => array(
                'pageSize' => 10,
                'pageVar' => 'page',
            ),
        ));
    }
}