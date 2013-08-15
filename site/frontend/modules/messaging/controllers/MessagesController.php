<?php

class MessagesController extends HController
{
    const ERROR_BLOCKED = 1;
    const ERROR_VALIDATION_FAILED = 2;

    public function filters()
    {
        return array(
            'accessControl',
            'ajaxOnly',
        );
    }

    public function accessRules()
    {
        return array(
            array('deny',
                'users' => array('?'),
            ),
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

    public function actionRestore()
    {
        $messageId = Yii::app()->request->getPost('messageId');
        MessagingMessageUser::model()->updateByPk(array(
            'user_id' => Yii::app()->user->id,
            'message_id' => $messageId,
        ), array('deleted' => 0));

        $response = array(
            'success' => true,
        );
        echo CJSON::encode($response);
    }

    public function actionEdit()
    {
        $messageId = Yii::app()->request->getPost('messageId');
        $text = Yii::app()->request->getPost('text');

        $message = MessagingMessage::model()->with('messageUsers')->findByPk($messageId);
        if ($message->author_id == Yii::app()->user->id && ! $message->isReadByInterlocutor) {
            $message->text = $text;
            $success = $message->save(true, array('text'));
            $response = array(
                'success' => $success,
            );
            echo CJSON::encode($response);
        }
    }

    public function actionCancel()
    {
        $messageId = Yii::app()->request->getPost('messageId');

        $message = MessagingMessage::model()->findByPk($messageId);
        if ($message->author_id == Yii::app()->user->id && ! $message->isReadByInterlocutor) {
            $success = $message->delete();
            $response = array(
                'success' => $success,
            );
            echo CJSON::encode($response);
        }
    }

    public function actionSend()
    {
        $threadId = Yii::app()->request->getPost('threadId');
        $interlocutorId = Yii::app()->request->getPost('interlocutorId');
        $text = Yii::app()->request->getPost('text');
        $images = Yii::app()->request->getPost('images', array());

        if (Blacklist::model()->isBlocked($interlocutorId, Yii::app()->user->id)) {
            $response = array(
                'success' => false,
                'error' => self::ERROR_BLOCKED,
            );

            echo CJSON::encode($response);
            Yii::app()->end();
        }

        $newThread = false;
        if ($threadId === null) {
            $thread = MessagingThread::model()->createThreadWith($interlocutorId);
            $threadId = $thread->id;
            $newThread = true;
        }
        $message = MessagingMessage::model()->create($text, $threadId, Yii::app()->user->id, $images);

        if ($message === false) {
            $data = array(
                'success' => false,
                'error' => self::ERROR_VALIDATION_FAILED,
            );
        } else {
            $data = array(
                'success' => true,
                'message' => $message->json,
                'time' => time(),
            );

            $receiverData = array(
                'message' => $message->json,
                'time' => time(),
                'contact' => array(
                    'user' => array(
                        'id' => (int) Yii::app()->user->model->id,
                        'firstName' => Yii::app()->user->model->first_name,
                        'lastName' => Yii::app()->user->model->last_name,
                        'gender' => (int) Yii::app()->user->model->gender,
                        'avatar' => Yii::app()->user->model->getAvatarUrl(24),
                        'online' => (bool) Yii::app()->user->model->online,
                        'isFriend' => (bool) Friend::model()->areFriends(Yii::app()->user->id, $interlocutorId),
                    ),
                ),
            );

            if ($newThread)
                $data['thread'] = $receiverData['contact']['thread'] = array(
                    'id' => (int) $thread->id,
                    'updated' => (int) time(),
                    'unreadCount' => (int) 0,
                    'hidden' => (bool) false,
                );

            $comet = new CometModel();
            $comet->send($interlocutorId, $receiverData, CometModel::MESSAGING_MESSAGE_RECEIVED);
        }

        echo CJSON::encode($data);
    }
}