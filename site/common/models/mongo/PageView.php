<?php
class PageView extends EMongoDocument
{
    public $views = 0;
    public $updated;

    public function getCollectionName()
    {
        return 'page_views';
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function rules()
    {
        return array(
            array('views, updated', 'safe'),
        );
    }

    public function findByPath($path)
    {
        return $this->findByPk($path);
    }

    public function viewsByPath($path)
    {
        if (($model = $this->findByPath($path)) !== null)
            return $model->views + 1;
        else
            return 1;
    }

    public function updateByPath($path)
    {
        $value = Yii::app()->cache->get($path);

        if ($value === false) {
            Yii::import('site.frontend.extensions.GoogleAnalytics');
            $ga = new GoogleAnalytics('alexk984@gmail.com', Yii::app()->params['gaPass']);
            $ga->setProfile('ga:53688414');
            $ga->setDateRange('2011-12-01', date('Y-m-d'));
            $report = $ga->getReport(array(
                'dimensions' => urlencode('ga:pagePath'),
                'metrics' => urlencode('ga:uniquePageviews'),
                'filters' => urlencode('ga:pagePath==' . $path),
                'max-results' => 1,
            ));

            var_dump($report);
            Yii::app()->end();
            if (!$report || !isset($report[$path]))
                return false;
            $count = $report[$path]['ga:uniquePageviews'];
            $model = $this->findByPath($path);
            if (!$model) {
                $model = new $this;
                $model->_id = $path;
            }
            Yii::app()->cache->set($path, $count, 24 * 3600);

            $model->views = (int)$count;
            $model->updated = time();
            $model->save();
            return $model;
        } else
            return $this->findByPath($path);
    }
}
