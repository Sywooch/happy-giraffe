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
        $this->renderPartial('index');
    }

    public function actionTest()
    {
        $contacts = Im::getContacts(Yii::app()->user->id, IM::IM_CONTACTS_ALL);
        foreach ($contacts as $c) {
            echo 'User #' . $c->id . '<br />';
            echo 'Dialog #' . $c->userDialog->dialog->id . '<br />';
            echo 'New - ' . $c->userDialog->dialog->unreadMessagesCount . '<br />';
            echo '<br />';
        }
    }
}