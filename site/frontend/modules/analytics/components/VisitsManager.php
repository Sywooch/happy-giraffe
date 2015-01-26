<?php
/**
 * @author Никита
 * @date 26/01/15
 */

namespace site\frontend\modules\analytics\components;


use site\frontend\modules\analytics\models\PageView;

class VisitsManager
{
    public $timeout = 300;

    public function sync($class)
    {
        $dp = new \CActiveDataProvider($class, array(
            'criteria' => array(
                'order' => 'id ASC',
            ),
        ));
        $iterator = new \CDataProviderIterator($dp, 100);
        /**
         * @var int $i
         * @var \CActiveRecord $model
         */
        foreach ($iterator as $i => $model) {
            $visits = $this->getVisits($model->url);
            if ($model->views != $visits) {
                $model->views = $visits;
                $model->update(array('views'));
            }
        }
    }

    public function getVisits($url)
    {
        /** @var \site\frontend\modules\analytics\models\PageView $model */
        $model = PageView::model()->findByPk($url);
        if ($model === null) {
            $model = new PageView();
            $model->_id = $url;
            $model->updated = time();
            $model->visits = 1;
            $model->save(false);
        } elseif (($model->updated + $this->timeout) > time()) {
            $model->updated = time();
            $model->visits = $this->fetchVisitsCount($url);
            $model->save(false);
        }
        return $model->visits;
    }

    protected function fetchVisitsCount($url)
    {
        return \Yii::app()->piwik->getVisits($url);
    }
} 