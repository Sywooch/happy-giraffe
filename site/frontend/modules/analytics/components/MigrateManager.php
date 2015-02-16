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
                        'start-index' => ($page - 1) * 1000 + 401,
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
        echo "start processResponse:\n";
        foreach ($response as $path => $row) {
            echo ++$this->i . '-' . $path . "\n";
            $model = PageView::getModel($path);
            echo "got model\n";
            $model->correction = $row['ga:visits'];
            echo "correction set\n";
            $model->save();
            echo "saved\n";
        }
        echo "end processResponse:\n";
    }
}