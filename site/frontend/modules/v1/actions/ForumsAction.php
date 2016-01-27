<?php

namespace site\frontend\modules\v1\actions;

class ForumsAction extends RoutedAction
{
    public function run()
    {
        $this->route('getForums', null, null, null);
    }

    public function getForums()
    {
        $this->controller->get(\Community::model(), $this);
    }
}