<?php

namespace site\frontend\modules\v1\actions;

class SectionsAction extends RoutedAction
{
    public function run() {
        $this->route('getSections', null, null, null);
    }

    public function getSections() {
        $this->controller->get(\CommunitySection::model());
    }
}