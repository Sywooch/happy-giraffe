<?php

namespace site\frontend\modules\v1\actions;

use site\frontend\modules\som\modules\activity\models\Activity;

class OnairAction extends RoutedAction
{
    public function run()
    {
        $this->route('getOnair', 'getOnair', 'getOnair', 'getOnair');
    }

    public function getOnair() {
        $this->controller->get(Activity::model());
    }
}