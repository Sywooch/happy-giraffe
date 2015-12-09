<?php

namespace site\frontend\modules\v1\actions;

class RubricsAction extends RoutedAction
{
    public function run() {
        $this->route('getRubrics', 'getRubrics', 'getRubrics', 'getRubrics');
    }

    public function getRubrics() {
        $this->controller->get(\CommunityRubric::model());
    }
}