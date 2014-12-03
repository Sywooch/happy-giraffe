<?php

namespace site\frontend\modules\rss\controllers;
use site\frontend\modules\rss\components\FeedGenerator;

/**
 * @author Никита
 * @date 28/11/14
 */

class DefaultController extends \HController
{
    public function actionUser($userId)
    {
        $dataProvider = new \MultiModelDataProvider(array(
            'site\frontend\modules\posts\models\Content' => array(
                'criteria' => new \CDbCriteria(array(
                    'condition' => 'authorId = :authorId',
                    'params' => array(':authorId' => $userId),
                )),
                'sortColumn' => 'dtimeCreate',
            ),
        ));
        $feed = new FeedGenerator($dataProvider);
        $feed->run();
    }
} 