<?php

class DefaultController extends HController
{
    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'users' => array('@'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionTest()
    {
        $user = User::getUserById(10023);
        $user->online = ! $user->online;
        $user->save(false);
    }
}