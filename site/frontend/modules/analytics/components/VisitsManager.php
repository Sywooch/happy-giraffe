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
    const TIMEOUT = 3600; // данные по ссылке обновляются не чаще, чем раз в TIMEOUT секунд
    const INTERVAL = 600; // после релиза, данные о действиях за INTERVAL период времени

    public function inc()
    {
        $startTime = time();
        $lastRun = \Yii::app()->getGlobalState(self::INC_LAST_RUN, time() - self::INTERVAL);
        $response = \Yii::app()->getModule('analytics')->piwik->makeRequest('Live.getLastVisitsDetails', array(
            'minTimestamp' => $lastRun,
            'filter_limit' => -1,
        ));
        $urls = $this->parseLiveReport($response);
        foreach ($urls as $url => $count) {
            $model = PageView::getModel($url);
            $timeLeft = time() - $model->updated;
            if ($timeLeft > self::TIMEOUT) {
                \Yii::app()->gearman->client()->doBackground('processUrl', $url, md5($url));
            } else {
                $model->visits += $count;
                $model->save();
            }
        }
        \Yii::app()->setGlobalState(self::INC_LAST_RUN, $startTime);
    }

    public function processUrl($url)
    {
        $model = PageView::getModel($url);
        $model->visits = $this->fetchVisitsCount($url);
        $model->save();
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

    protected function parseLiveReport($response)
    {
        $urls = array();
        foreach ($response as $row) {
            foreach ($row['actionDetails'] as $action) {
                $urls[] = $action['url'];
            }
        }
        return array_count_values($urls);
    }

    protected function fetchVisitsCount($url)
    {
        return \Yii::app()->getModule('analytics')->piwik->getVisits($url);
    }
} 