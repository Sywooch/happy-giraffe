<?php

namespace site\frontend\modules\v1\actions;

class LoginAction extends RoutedAction
{
    public function run() {
        $this->route(null, 'login', null, null);
    }

    public function login() {
        if ($this->controller->auth()) {
            $this->controller->data = \User::model()->findByPk($this->controller->identity->getId());
            /*$_GET['id'] = $this->controller->identity->getId();
            $this->controller->get(\User::model());*/
        }
    }
}