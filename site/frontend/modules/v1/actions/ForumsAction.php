<?php

namespace site\frontend\modules\v1\actions;

class ForumsAction extends RoutedAction
{
    public function run() {
        $this->route('getForums', 'getForums', 'getForums', 'getForums');
    }

    public function getForums() {
        $this->controller->get(\Community::model());
    }
}