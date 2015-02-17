<?php
namespace site\frontend\modules\ads;

/**
 * @author Никита
 * @date 04/02/15
 */

class AdsModule extends \CWebModule
{
    public $advertiserId;
    public $lines;
    public $templates;

    public $controllerNamespace = '\site\frontend\modules\ads\controllers';
}