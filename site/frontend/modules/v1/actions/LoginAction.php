<?php

namespace site\frontend\modules\v1\actions;

class LoginAction extends RoutedAction
{
    public function run() {
        $this->route('login', 'login', 'login', 'login');
    }

    public function login() {
        if ($this->controller->auth()) {
            $this->controller->data = \User::model()->findByPk($this->controller->identity->getId());
        }
    }
}