<?php
/**
 * Виджет для отображения социальных кнопок
 *
 * Используется как внутри модуля для форм логина и регистрации, так и за его пределами для реализации социальных
 * кнопок аутентификации.
 */

class AuthWidget extends EAuthWidget
{
    public $cssFile = false;
    public $view = 'outside';
    public $action = '/signup/login/social';
    public $predefinedServices = array('vkontakte', 'odnoklassniki');

    public function run()
    {
        $this->registerAssets();
        $this->render($this->view, array(
            'id' => $this->getId(),
            'services' => $this->services,
            'action' => $this->action,
        ));
    }
}