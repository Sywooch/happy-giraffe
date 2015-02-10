<?php
namespace site\frontend\modules\ads\components\creatives;

/**
 * @author Никита
 * @date 06/02/15
 */

abstract class BaseCreative extends \CBaseController
{
    public $template;
    public $model;
    public $modelClass;

    public function init()
    {

    }

    public function getHtml()
    {
        return $this->renderFile($this->getViewFile($this->template), null, true);
    }

    public function getViewFile($viewName)
    {
        return \Yii::getPathOfAlias('ads.views.templates') . DIRECTORY_SEPARATOR . $viewName . '.php';
    }

    abstract public function getName();
    abstract public function getUrl();
}