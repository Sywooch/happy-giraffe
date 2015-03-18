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
    const FLUSH_INTERVAL = 300; //
    const VISITS_COUNT_THRESHOLD = 100;

    public $hitsCacheComponent = 'cache';
    public $bufferCacheComponent = 'cache';

    /**
     * @var \CCache
     */
    protected $hitsCache;

    /**
     * @var \CCache
     */
    protected $bufferCache;

    public function init()
    {
        $this->hitsCache = \Yii::app()->{$this->hitsCacheComponent};
        $this->bufferCache = \Yii::app()->{$this->bufferCacheComponent};

        parent::init();
    }

    public function processVisit($path)
    {
        if ($this->isNewVisit($path)) {
            $this->countVisit($path);
            return true;
        }
        return false;
    }

    public function getVisits($path)
    {
        return PageView::getModel($path)->getCounter();
    }

    public function flushBuffer()
    {
        $lastFlush = \Yii::app()->getGlobalState(self::GLOBAL_STATE_LAST_FLUSH);
        $value = $this->bufferCache->get(self::VISITS_BUFFER_KEY);

        var_dump($value);

        $paths = ($value === false) ? array() : $value;
        $flushAll = $lastFlush === null || (time() - self::FLUSH_INTERVAL) > $lastFlush;
        foreach ($paths as $path => $count) {
            if ($flushAll || $count > self::VISITS_COUNT_THRESHOLD) {
                $model = PageView::getModel($path);
                $model->incVisits($count);
                unset ($paths[$path]);
            }
        }
        $this->bufferCache->set(self::VISITS_BUFFER_KEY, $paths);
    }

    public function getTrackingCode()
    {
        return \Yii::app()->controller->renderPartial('application.modules.analytics.views._counter', null, true);
    }

    protected function countVisit($path)
    {
        $value = $this->bufferCache->get(self::VISITS_BUFFER_KEY);
        $paths = ($value === false) ? array() : $value;
        if (! isset($paths[$path])) {
            $paths[$path] = 1;
        } else {
            $paths[$path] += 1;
        }

        $this->bufferCache->set(self::VISITS_BUFFER_KEY, $paths);
    }

    protected function isNewVisit($path)
    {
        $key = $this->getVisitKey($path);
        $value = $this->hitsCache->get($key);
        if ($value === false) {
            $this->hitsCache->set($key, null, self::VISITS_INTERVAL);
        }
        return ($value === false);
    }

    protected function getVisitKey($path)
    {
        return $path . $this->getVisitorHash();
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
        return md5(json_encode($seedArray));
    }
} 