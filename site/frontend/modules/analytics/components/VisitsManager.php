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
//    const VISITS_BUFFER_KEY = 'Analytics.VisitorsManager.visits';
    const VISITS_INTERVAL = 1800; // 3 часа
//    const FLUSH_INTERVAL = 300; //
//    const VISITS_COUNT_THRESHOLD = 100;

    public $hitsCacheComponent = 'cache';
//    public $bufferCacheComponent = 'cache';

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
//        $this->bufferCache = \Yii::app()->{$this->bufferCacheComponent};

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

    public function getVisits($path = null)
    {
        if ($path === null) {
            $path = \Yii::app()->request->requestUri;
        }

        return PageView::getModel($path)->getCounter();
    }

//    public function flushBuffer()
//    {
//        $value = $this->bufferCache->get(self::VISITS_BUFFER_KEY);
//        $this->bufferCache->set(self::VISITS_BUFFER_KEY, array());
//
//        $paths = ($value === false) ? array() : $value;
//        foreach ($paths as $path => $count) {
//            $model = PageView::getModel($path);
//            $model->incVisits($count);
//            unset ($paths[$path]);
//        }
//    }

//    public function showBuffer()
//    {
//        return $this->bufferCache->get(self::VISITS_BUFFER_KEY);
//    }

    public function getTrackingCode()
    {
        return \Yii::app()->controller->renderPartial('application.modules.analytics.views._counter', null, true);
    }

    protected function countVisit($path)
    {
        $model = PageView::getModel($path);
        $model->incVisits(1);
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