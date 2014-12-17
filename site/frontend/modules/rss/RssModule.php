<?php

namespace site\frontend\modules\rss;

class RssModule extends \CWebModule
{
    public $controllerNamespace = '\site\frontend\modules\rss\controllers';

    public function init()
    {
        // this method is called when the module is being created
        // you may place code here to customize the module or the application

        // import the module-level models and components
        $this->setImport(array(
            'rss.models.*',
            'rss.components.*',
        ));
    }
}
