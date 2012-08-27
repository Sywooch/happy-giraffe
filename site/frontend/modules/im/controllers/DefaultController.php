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
        $newCount = Im::getContactsCount(Yii::app()->user->id, Im::IM_CONTACTS_NEW);
        $onlineCount = Im::getContactsCount(Yii::app()->user->id, Im::IM_CONTACTS_ONLINE);
        $friendsCount = Im::getContactsCount(Yii::app()->user->id, Im::IM_CONTACTS_FRIENDS);
        $this->renderPartial('index', compact('newCount', 'onlineCount', 'friendsCount'), false, true);
    }

    public function actionContacts($type = Im::IM_CONTACTS_ALL)
    {
        $contacts = Im::getContacts(Yii::app()->user->id, $type);
        echo $this->renderPartial('contacts', compact('contacts'));
    }

    public function actionTest()
    {
        $contacts = Im::getContacts(Yii::app()->user->id, Im::IM_CONTACTS_FRIENDS);
        foreach ($contacts as $c)
            echo $c->id . '<br />';

        Yii::app()->end();
        $user = User::getUserById(10023);
        $user->online = ! $user->online;
        $user->save(false, array('online'));
    }
}