<?php

class BirthDateModule extends CWebModule
{
    public function init()
    {
        $this->setImport(array(
            'birthDate.models.*',
            //'birthDate.components.*',
        ));
    }

    public function beforeControllerAction($controller, $action)
    {
        if (parent::beforeControllerAction($controller, $action)) {
            return true;
        } else
            return false;
    }
}
