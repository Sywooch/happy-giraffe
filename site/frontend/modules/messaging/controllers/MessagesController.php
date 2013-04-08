<?php

class MessagesController extends HController
{
    public function filters()
    {
        return array(
//            'ajaxOnly',
//            'postOnly',
        );
    }

    public function actionDelete()
    {
        $messageId = Yii::app()->request->getPost('messageId');
        MessagingMessageUser::model()->updateByPk(array(
            'user_id' => Yii::app()->user->id,
            'message_id' => $messageId,
        ), array('deleted' => 1));

        $response = array(
            'success' => true,
        );
        echo CJSON::encode($response);
    }

    public function actionSend()
    {
        $threadId = Yii::app()->request->getPost('threadId');
        $interlocutorId = Yii::app()->request->getPost('interlocutorId');
        $text = Yii::app()->request->getPost('text');

        $data = array();
        if ($threadId === null) {
            $thread = MessagingThread::model()->createThreadWith($interlocutorId);
            $threadId = $thread->id;
            $data['thread'] = array(
                'id' => $thread->id,
                'updated' => time(),
                'unreadCount' => 0,
                'hidden' => false,
            );
        }

        $message = MessagingMessage::model()->create($text, $threadId);
        $data['message'] = array(
            'id' => (int) $message->id,
            'author_id' => (int) $message->author_id,
            'text' => $message->text,
            'created' => Yii::app()->dateFormatter->format("d MMMM yyyy, H:mm", time()),
            'read' => false,
        );

        $comet = new CometModel();
        $comet->send($interlocutorId, $data);
        echo CJSON::encode($data);
    }
}