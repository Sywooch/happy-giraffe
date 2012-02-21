<?php
class PageView extends EMongoDocument
{
    public $views = 0;
    public $updated;
    public function getCollectionName()
    {
        return 'page_views';
    }

    public static function model($className=__CLASS__)
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
        if(($model = $this->findByPath($path)) !== null)
            return $model->views;
        else
            return 0;
    }

    public function updateByPath($path)
    {
        Yii::import('site.frontend.extensions.GoogleAnalytics');
        $ga = new GoogleAnalytics('lnghosteg@gmail.com', 'EXJhWLcoT');
        $ga->setProfile('ga:53688414');
        $ga->setDateRange('2011-12-01', date('Y-m-d'));
        $report = $ga->getReport(array(
            'dimensions'=>urlencode('ga:pagePath'),
            'metrics'=>urlencode('ga:visits'),
            'filters'=>urlencode('ga:pagePath==' . $path),
            'max-results' => 1,
        ));
        if(!$report || !isset($report[$path]))
            return false;
        $count = $report[$path]['ga:visits'];
        $model = $this->findByPath($path);
        if(!$model)
        {
            $model = new $this;
            $model->_id = $path;
        }
        $model->views = $count;
        $model->updated = time();
        $model->save();
        return $model;
    }
}
