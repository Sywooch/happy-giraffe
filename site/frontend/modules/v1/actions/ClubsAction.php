<?php

namespace site\frontend\modules\v1\actions;

class ClubsAction extends RoutedAction
{
    public function run() {
        $this->route('getClubs', 'getClubs', 'getClubs', 'getClubs');
    }

    public function getClubs() {
        $this->controller->get(\CommunityClub::model());
    }
}