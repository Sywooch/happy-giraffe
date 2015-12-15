<?php

namespace site\frontend\modules\v1\actions;

class RubricsAction extends RoutedAction
{
    public function run()
    {
        $this->route('getRubrics', null, null, null);
    }

    public function getRubrics()
    {
        $this->controller->get(\CommunityRubric::model(), $this);
    }
}