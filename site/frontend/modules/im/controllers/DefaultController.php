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

    public function actionDialog($interlocutor_id)
    {
        $contact = Im::getDialogWith(Yii::app()->user->id, $interlocutor_id);
        $this->renderPartial('_dialog', compact('contact', 'interlocutor_id'));
    }

    public function actionChangeStatus($id)
    {
        $user = User::getUserById($id);
        $user->online = ! $user->online;
        $user->save(false, array('online'));
    }

    public function actionTest()
    {
        $onlineCount = Im::getContactsCount(Yii::app()->user->id, Im::IM_CONTACTS_NEW);
        echo $onlineCount;
    }
}