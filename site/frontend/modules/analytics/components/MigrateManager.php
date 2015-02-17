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

    private $i = 0;
    private $t;

    private $_patterns = array(
        '^/community/\d+/forum/\w+/\d+/$',
        '^/user/\d+/blog/post\d+/$',
    );

    public function __construct()
    {
        \Yii::import('site.frontend.extensions.GoogleAnalytics');
        $this->ga = new \GoogleAnalytics('nikita@happy-giraffe.ru', 'ummvxhwmqzkrpgzj');
        $this->ga->setProfile('ga:53688414');
        $this->ga->setDateRange('2012-08-01', '2015-02-12');
    }

    public function run()
    {
        $this->t = time();
        ini_set('max_execution_time', 0);
        ini_set('max_input_time', -1);
        ini_set('memory_limit', -1);
        set_time_limit(0);
        ini_set('display_errors',1);
        ini_set('display_startup_errors',1);
        error_reporting(-1);
        foreach ($this->_patterns as $pattern) {
            $this->processByRegex($pattern);
        }
    }

    protected function processByRegex($pattern)
    {
        $page = 0;
        do {
            $page++;
            $response = null;
            do {
                try {
                    $response = $this->ga->getReport(array(
                        'metrics' => 'ga:visits',
                        'start-index' => ($page - 1) * 1000 + 1,
                        'max-results' => 1000,
                        'dimensions' => 'ga:pagePath',
                        'filters' => 'ga:pagePath=~' . urlencode($pattern),
                    ));
                } catch (\Exception $e) {
                    sleep(10);
                }
            } while ($response === null);
            echo "page $page(" . count($response) . ") \n";
            $this->processResponse($response);
        } while (count($response) > 0);
    }

    protected function processResponse($response)
    {
        foreach ($response as $path => $row) {
            echo (time() - $this->t) . "\n";
            echo ++$this->i . '-' . $path . "\n";
            $model = PageView::getModel($path);
            $model->correction = $row['ga:visits'];
            echo "save\n";
            $model->save();
        }
    }
}