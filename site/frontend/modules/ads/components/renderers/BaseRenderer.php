<?php
namespace site\frontend\modules\ads\components\renderers;

/**
 * @author Никита
 * @date 06/02/15
 */

class BaseRenderer extends \CBaseController
{
    public $model;
    public $template;

    public function render()
    {
        return $this->renderFile($this->template, null, true);
    }

    public function getViewFile($viewName)
    {
        return 'ads.views.templates.' . $viewName;
    }
}