<?php

namespace site\frontend\modules\v1\actions;

use site\frontend\modules\posts\models\Label;

class PostLabelAction extends RoutedAction
{
    public function run()
    {
        $this->route('getPostLabel', 'getPostLabel', 'getPostLabel', 'getPostLabel');
    }

    public function getPostLabel() {
        $this->controller->get(Label::model());
    }
}