<?php
/**
 * @author Никита
 * @date 30/01/15
 */

namespace site\frontend\modules\analytics\components;


use site\frontend\modules\analytics\models\PageView;
use site\frontend\modules\posts\models\Content;

class MigrateManager
{
    public $ga;

    private $_patterns = array(
        //'^/community/\d+/forum/\w+/\d+/$',
        '^/user/\d+/blog/post\d+/$',
    );

    public function __construct()
    {
        \Yii::import('site.frontend.extensions.GoogleAnalytics');
        $this->ga = new \GoogleAnalytics('nikita@happy-giraffe.ru', 'ummvxhwmqzkrpgzj');
        $this->ga->setProfile('ga:53688414');
        $this->ga->setDateRange('2011-01-01', '2015-01-30');
    }

    public function run()
    {
//        foreach ($this->_patterns as $pattern) {
//            $this->processByRegex($pattern);
//        }

        $dp = new \CActiveDataProvider('site\frontend\modules\posts\models\Content', array(
            'criteria' => array(
                'order' => 'id DESC',
                'limit' => 1000,
            ),
        ));
        $iterator = new \CDataProviderIterator($dp, 100);

        $filter = array();
        foreach ($iterator as $i => $post) {
            $path = parse_url($post->url, PHP_URL_PATH);
            $filter[] = 'ga:pagePath==' . $path;

            if ((($i + 1) % 100) == 0) {
                $response = $this->ga->getReport(array(
                    'metrics' => 'ga:visits',
                    'dimensions' => 'ga:pagePath',
                    'filters' => implode(',', $filter),
                ));
                var_dump($filter); die;
                $this->processResponse($response);
            }
        }
    }

    protected function processByRegex($pattern)
    {
        $page = 0;
        do {
            $page++;
            $response = $this->ga->getReport(array(
                'metrics' => 'ga:visits',
                'start-index' => ($page - 1) * 1000 + 1,
                'max-results' => 1000,
                'dimensions' => 'ga:pagePath',
                'filters' => 'ga:pagePath=~' . urlencode($pattern),
            ));

            foreach ($response as $path => $row) {
                $this->processRow($row);
            }
        } while (count($response) > 0);
        var_dump($response);
    }

    protected function processResponse($response)
    {
        foreach ($response as $path => $row) {
            $model = PageView::getModel($row);
            $model->correction = $row['ga:visits'];
            $model->save();
        }e
    }
}