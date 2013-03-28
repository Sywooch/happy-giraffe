<?php

class MessagesController extends HController
{
    public function filters()
    {
        return array(
//            'ajaxOnly',
            'postOnly',
        );
    }

    public function actionSend()
    {
        $thread_id = Yii::app()->request->getPost('thread_id');
        $text = Yii::app()->request->getPost('text');

        $thread = MessagingThread::model()->with('threadUsers')->findByPk($thread_id);
        if ($thread === null)
            throw new CHttpException(403, 'Thread does not exist.');

        $message = new MessagingMessage();
        $message->author_id = Yii::app()->user->id;
        $message->thread_id = $thread_id;
        $message->text = $text;
        $messageUser1 = new MessagingMessageUser();
        $messageUser1->user_id = Yii::app()->user->id;
        $messageUser2 = new MessagingMessageUser();
        $messageUser2->user_id = 22;
        $message->messageUsers = array($messageUser1, $messageUser2);

        $success = $message->withRelated->save(true, array('messageUsers'));
        $response = array(
            'success' => $success,
        );
        echo CJSON::encode($response);
    }
}