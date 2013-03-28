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

    /**
     * Отправка сообщения
     *
     * Добавляет сообщение в диалог
     *
     * @throws CHttpException
     */
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
        $messageUsers = array();
        foreach ($thread->threadUsers as $threadUser) {
            $messageUser = new MessagingMessageUser();
            $messageUser->user_id = $threadUser->user_id;
            if (Yii::app()->user->id != $threadUser->user_id)
                $messageUser->read = 0;
            $messageUsers[] = $messageUser;
        }
        $message->messageUsers = $messageUsers;

        $success = $message->withRelated->save(true, array('messageUsers'));
        $response = array(
            'success' => $success,
        );
        echo CJSON::encode($response);
    }
}