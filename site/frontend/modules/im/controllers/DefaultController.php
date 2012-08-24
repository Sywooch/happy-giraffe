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

    public function actionContacts($type = Im::IM_CONTACTS_ALL)
    {
        $contacts = Im::getContacts(Yii::app()->user->id, $type);
        echo $this->renderPartial('contacts', compact('contacts'));
    }
}