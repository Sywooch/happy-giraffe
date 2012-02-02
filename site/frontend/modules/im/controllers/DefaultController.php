<?php

class DefaultController extends Controller
{
    public $layout = '//layouts/new';

    public function actionIndex()
    {
        if (Yii::app()->user->isGuest)
            $this->redirect(array('site/index'));

        $dialogs = MessageDialog::GetUserDialogs();
        $this->render('index', array(
            'dialogs' => $dialogs
        ));
    }

    public function actionDialog($id)
    {
        $messages = MessageLog::GetLastMessages($id);

        $this->render('dialog', array(
            'messages' => $messages,
            'id'=>$id
        ));
    }

    public function actionSetRead()
    {
        $dialog = Yii::app()->request->getPost('dialog');
        $last_message_id = Yii::app()->request->getPost('id');
        MessageDialog::SetRead($dialog, $last_message_id);
    }

    public function actionCreateMessage()
    {
        $dialog = Yii::app()->request->getPost('dialog');
        $text = Yii::app()->request->getPost('text');
        $message = MessageLog::NewMessage($dialog, Yii::app()->user->getId(), CHtml::encode($text));

        $response = array(
            'id' => $message->id,
            'status' => true,
            'html' => $this->renderPartial('_message', array(
                'message' => $message
            ), true)
        );
        echo CJSON::encode($response);
    }

    public function actionMoreMessages()
    {
        $dialog_id = Yii::app()->request->getPost('dialog_id');
        $id = Yii::app()->request->getPost('id');
        $messages = MessageLog::GetMessagesBefore($dialog_id, $id);

        if (!empty($messages))
            $response = array(
                'status' => true,
                'html' => $this->renderPartial('_messages', array('messages' => $messages), true)
            );
        else $response = array('status' => false);

        echo CJSON::encode($response);
    }
}