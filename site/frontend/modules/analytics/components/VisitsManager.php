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
        $lastRun = \Yii::app()->getGlobalState(self::INC_LAST_RUN, 0);
        $minTimestamp = max($lastRun, time() - self::TIMEOUT);
        $response = \Yii::app()->getModule('analytics')->piwik->makeRequest('Live.getLastVisitsDetails', array(
            'minTimestamp' => $minTimestamp,
            'filter_limit' => -1,
        ));
        $urls = $this->parseLiveReport($response);
        $urlsCounts = array_count_values($urls);
        echo "urls: " . count($urls) . "\n";
        $syncQueue = 0;
        foreach ($urlsCounts as $url => $count) {
            $model = PageView::getModel($url);
            $timeLeft = time() - $model->synced;
            if ($timeLeft > self::TIMEOUT) {
                \Yii::app()->gearman->client()->doBackground('processUrl', $url, md5($url));
                $syncQueue++;
            } else {
                $model->visits += $count;
                $model->save();
            }
        }
        \Yii::app()->setGlobalState(self::INC_LAST_RUN, $startTime);
        echo "added to sync: $syncQueue\n";
        echo "time left: " . (time() - $startTime) . "\n";
    }

    public function processUrl($url)
    {
        $model = PageView::getModel($url);
        $model->visits = $this->fetchVisitsCount($url);
        $model->synced = time();
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
        return array_filter($urls, function($v) {
            return ($v !== null) && (strpos($v, \Yii::app()->homeUrl) !== false);
        });
    }

    protected function fetchVisitsCount($url)
    {
        return \Yii::app()->getModule('analytics')->piwik->getVisits($url);
    }
} 