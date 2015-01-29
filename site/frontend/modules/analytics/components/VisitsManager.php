<?php
/**
 * @author Никита
 * @date 26/01/15
 * @todo тест
 */

namespace site\frontend\modules\analytics\components;


use site\frontend\modules\analytics\models\PageView;
use site\frontend\modules\editorialDepartment\models\Content;

class VisitsManager
{
    const INC_LAST_RUN = 'VisitsManager.incLastRun';

    public function inc()
    {
        $lastRun = 0;// \Yii::app()->getGlobalState(self::INC_LAST_RUN, 0);
        $start = time();
        $response = \Yii::app()->getModule('analytics')->piwik->makeRequest('Live.getLastVisitsDetails', array(
            'minTimestamp' => $lastRun,
        ));

        $urls = array();
        foreach ($response as $row) {
            foreach ($row['actionDetails'] as $action) {
                $urls[] = $action['url'];
            }
        }

        $urls = array_unique($urls);

        foreach ($urls as $url) {
            $model = $this->getModel($url);
            $model->visits = $this->fetchVisitsCount($url);
            $model->save();

            $m = $this->getModelByUrl($url);
            $m->views = $model->visits;
            $m->update(array('views'));
        }
        //\Yii::app()->setGlobalState(self::INC_LAST_RUN, $start);
    }

    protected function getModel($url)
    {
        $model = PageView::model()->findByPk($url);
        if ($model === null) {
            $model = new PageView();
            $model->_id = $url;
        }
        return $model;
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
            $model->views = $this->getModel($model->url)->visits;
            $model->update(array('views'));
        }
    }

    protected function getModelByUrl($url)
    {
        if (preg_match('#user/(:?\d+)/blog/post(\d+)#', $url, $matches)) {
            $id = $matches[1];
            return Content::model()->findByPk($id);
        }
        return null;
    }

    protected function fetchVisitsCount($url)
    {
        return \Yii::app()->getModule('analytics')->piwik->getVisits($url);
    }
} 