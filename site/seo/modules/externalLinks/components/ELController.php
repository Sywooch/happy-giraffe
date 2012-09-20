<?php

class ELController extends SController
{
    public $layout = '/layouts/externalLinks';
    public $icon = 2;
    public $pageTitle = 'Внешние ссылки';

    public function beforeAction($action)
    {
        if (!Yii::app()->user->checkAccess('externalLinks-manager-panel'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return true;
    }
}