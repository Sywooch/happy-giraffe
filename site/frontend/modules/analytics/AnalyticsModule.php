<?php
namespace site\frontend\modules\analytics;

/**
 * @author Никита
 * @date 26/01/15
 */

class AnalyticsModule extends \CWebModule
{
    public $controllerNamespace = '\site\frontend\modules\analytics\controllers';

    public function init()
    {
        $this->setComponents(array(
            'piwik' => array(
                'class' => '\site\frontend\modules\analytics\components\PiwikHttpApi',
                'baseUrl' => 'http://piwik.happy-giraffe.ru',
                'idSite' => 3,
                'token' => '4e9461d8cd53eb3381c55ac9344b0e5c',
            ),
        ));
    }
}