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
        $this->renderPartial('index', null, false, true);
    }

    public function actionContacts($type = Im::IM_CONTACTS_ALL)
    {
        $contacts = Im::getContacts(Yii::app()->user->id, $type);
        echo $this->renderPartial('contacts', compact('contacts'));
    }

    public function actionTest()
    {
        $user = User::getUserById(10023);
        $user->online = ! $user->online;
        $user->save(false, array('online'));
    }
}