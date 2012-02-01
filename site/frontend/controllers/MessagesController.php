<?php

class MessagesController extends Controller
{
    public function actionIndex(){
        $this->render('index');
    }

    public function actionDialog(){

    }

    public function actionSetRead(){
        $dialog = Yii::app()->request->getPost('dialog');
        MessageDialog::SetRead($dialog);
    }

    public function actionCreateMessage()
    {
        $dialog = Yii::app()->request->getPost('dialog');
        $text = Yii::app()->request->getPost('text');
        MessageLog::NewMessage($dialog, Yii::app()->user->getId(), $text);
    }
}
