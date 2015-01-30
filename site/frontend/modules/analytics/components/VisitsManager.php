<?php
/**
 * @author Никита
 * @date 26/01/15
 * @todo тест
 */

namespace site\frontend\modules\analytics\components;


use site\frontend\modules\analytics\models\PageView;
use site\frontend\modules\posts\models\Content;


class VisitsManager
{
    const INC_LAST_RUN = 'VisitsManager.incLastRun';

    public function inc()
    {
        $lastRun = 0;// \Yii::app()->getGlobalState(self::INC_LAST_RUN, 0);
        $response = \Yii::app()->getModule('analytics')->piwik->makeRequest('Live.getLastVisitsDetails', array(
            'minTimestamp' => $lastRun,
        ));
        $urls = $this->parseLiveReport($response);
        foreach ($urls as $url) {
            $model = PageView::getModel($url);
            $model->visits = $this->fetchVisitsCount($url);
            $model->save();
            $entity = $model->getEntity();
            if ($entity !== null) {
                $data[] = $entity->id;
                $entity->views = $model->getCounter();
                $entity->update(array('views'));
            }
        }
        //\Yii::app()->setGlobalState(self::INC_LAST_RUN, time());
    }

    protected function parseLiveReport($response)
    {
        $urls = array();
        foreach ($response as $row) {
            foreach ($row['actionDetails'] as $action) {
                $urls[] = $action['url'];
            }
        }
        return array_unique($urls);
    }

    public function sync($class)
    {
        $dp = new \CActiveDataProvider($class, array(
            'criteria' => array(
                'order' => 'id ASC',
            ),
        ));
        $iterator = new \CDataProviderIterator($dp, 100);
        /** @var \CActiveRecord $model */
        foreach ($iterator as $model) {
            $model->views = PageView::getModel($model->url)->getCounter();
            $model->update(array('views'));
        }
    }

    protected function fetchVisitsCount($url)
    {
        return \Yii::app()->getModule('analytics')->piwik->getVisits($url);
    }
} 