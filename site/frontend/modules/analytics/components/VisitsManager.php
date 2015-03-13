<?php
/**
 * @author Никита
 * @date 26/01/15
 * @todo тест
 */

namespace site\frontend\modules\analytics\components;


use site\frontend\modules\analytics\models\PageView;
use site\frontend\modules\posts\models\Content;


class VisitsManager extends \CApplicationComponent
{
    const VISITOR_HASH_KEY_PREFIX = 'Analytics.VisitorsManager.visitorsHash';
    const VISITS_BUFFER_KEY = 'Analytics.VisitorsManager.visits';
    const GLOBAL_STATE_LAST_FLUSH = 'Analytics.VisitorsManager.lastFlush';
    const VISITS_INTERVAL = 10800; // 3 часа
    const FLUSH_INTERVAL = 300;
    const VISITS_COUNT_THRESHOLD = 100;

    public function processVisit($path)
    {
        if ($this->isNewVisit($path)) {
            $this->countVisit($path);
        }
    }

    public function getVisits($path)
    {
        return PageView::getModel($path)->visits;
    }

    public function flushBuffer()
    {
        $lastFlush = \Yii::app()->getGlobalState(self::GLOBAL_STATE_LAST_FLUSH);
        $paths = \Yii::app()->cache->get(self::VISITS_BUFFER_KEY);
        $flushAll = $lastFlush === null || (time() - self::FLUSH_INTERVAL) > $lastFlush;
        foreach ($paths as $path => $count) {
            $model = PageView::getModel($path);
            if ($flushAll || $count > self::VISITS_COUNT_THRESHOLD) {
                $model->incVisits($count);
            }
        }
    }

    protected function countVisit($path)
    {
        $value = \Yii::app()->cache->get(self::VISITS_BUFFER_KEY);
        $paths = ($value === false) ? array() : $value;
        if (! isset($paths[$path])) {
            $paths[$path] = 1;
        } else {
            $paths[$path] += 1;
        }
        \Yii::app()->cache->set(self::VISITS_BUFFER_KEY, $paths);
    }

    protected function isNewVisit($path)
    {
        $key = $this->getVisitKey($path);
        $value = \Yii::app()->cache->get($key);
        if ($value !== false) {
            \Yii::app()->cache->set($key, null, self::VISITS_INTERVAL);
        }
        return ($value === false);
    }

    protected function getVisitKey($path)
    {
        return md5($path . $this->getVisitorHash());
    }

    protected function getVisitorHash()
    {
        if (\Yii::app()->user->isGuest) {
            $seedArray = array(
                \Yii::app()->request->getUserHostAddress(),
                \Yii::app()->request->getUserAgent(),
            );
        } else {
            $seedArray = array(\Yii::app()->user->id);
        }
        array_unshift($seedArray, self::VISITOR_HASH_KEY_PREFIX);
        return md5(implode('.', $seedArray));
    }
} 