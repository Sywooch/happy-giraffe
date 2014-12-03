<?php

namespace site\frontend\modules\rss\controllers;

/**
 * @author Никита
 * @date 28/11/14
 */

class DefaultController extends \HController
{
    public function actions()
    {
        return array(
            'test' => array(
                'class' => 'site\frontend\modules\rss\components\RssAction',
                'dataProvider' => $this->getIndexDataProvider(),
            ),
        );
    }

    protected function getIndexDataProvider()
    {
        $dataProvider = new \CActiveDataProvider('site\frontend\modules\posts\models\Content');
        return $dataProvider;
    }
} 