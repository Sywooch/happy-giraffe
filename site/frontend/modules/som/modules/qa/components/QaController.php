<?php
/**
 * @author Никита
 * @date 18/11/15
 */

namespace site\frontend\modules\som\modules\qa\components;


class QaController extends \LiteController
{
    public $litePackage = 'faq';
    public $layout = '/layouts/main';

    public $sidebar = array();

    public function renderSidebarClip()
    {
        $this->beginClip('sidebar');
        foreach ($this->sidebar as $view => $params) {
            if (is_int($view)) {
                $view = $params;
                $params = array();
            }
            $this->renderPartial('/_sidebar/' . $view, $params);
        }
        $this->endClip();
    }
}