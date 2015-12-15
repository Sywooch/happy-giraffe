<?php

namespace site\frontend\modules\v1\actions;

class UsersAction extends RoutedAction
{
    public function run()
    {
        $this->route('getUsers', 'getUsers', 'getUsers', 'getUsers');
    }

    public function getUsers()
    {
        $this->controller->get(\User::model(), $this);
    }
}