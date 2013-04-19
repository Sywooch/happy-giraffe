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
        $images = Yii::app()->request->getPost('images', array());

        $receiverData = array(
            'contact' => array(
                'user' => array(
                    'id' => (int) Yii::app()->user->model->id,
                    'firstName' => Yii::app()->user->model->first_name,
                    'lastName' => Yii::app()->user->model->last_name,
                    'gender' => (int) Yii::app()->user->model->gender,
                    'avatar' => Yii::app()->user->model->getAva('small'),
                    'online' => (bool) Yii::app()->user->model->online,
                    'isFriend' => (bool) Yii::app()->user->model->isFriend($interlocutorId),
                ),
            ),
        );
        $data = array();

        if ($threadId === null) {
            $thread = MessagingThread::model()->createThreadWith($interlocutorId);
            $threadId = $thread->id;
            $data['thread'] = $receiverData['contact']['thread'] = array(
                'id' => $thread->id,
                'updated' => time(),
                'unreadCount' => 0,
                'hidden' => false,
            );
        }

        $message = MessagingMessage::model()->create($text, $threadId, Yii::app()->user->id, $images);

        $receiverData['message'] = $data['message'] = $message->json;
        $receiverData['time'] = $data['time'] = time();

        $comet = new CometModel();
        $comet->send($interlocutorId, $receiverData, CometModel::MESSAGING_MESSAGE_RECEIVED);
        echo CJSON::encode($data);
    }

    public function test()
    {
        $id = Yii::app()->request->getQuery('id');
        $message = MessagingMessage::model()->findByPk($id);
        print_r($message->JSON);
    }
}