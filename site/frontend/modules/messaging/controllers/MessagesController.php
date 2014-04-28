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
		$me = Yii::app()->user->id;
		// Обновим дату удаления
        MessagingMessageUser::model()->updateByPk(array(
            'user_id' => $me,
            'message_id' => $messageId,
        ), array('dtime_delete' => new CDbExpression('NOW()')));
		
        $response = array(
            'success' => true,
        );
        echo CJSON::encode($response);
		
		// Подготовим и отправим событие
		$messageModel = MessagingMessage::model()->withMyStatsOnTop($me, false)->findByPk($messageId);
		$message = DialogForm::messageToJson($messageModel, $me, $messageModel->messageUsers[1]->user_id);
		$comet = new CometModel();
		$comet->send($me, array('message' => $message), CometModel::MESSAGING_MESSAGE_DELETED);
    }

    public function actionRestore()
    {
		$me = Yii::app()->user->id;
        $messageId = Yii::app()->request->getPost('messageId');
        MessagingMessageUser::model()->updateByPk(array(
            'user_id' => $me,
            'message_id' => $messageId,
        ), array('dtime_delete' => null));

        $response = array(
            'success' => true,
        );
        echo CJSON::encode($response);
		
		// Подготовим и отправим событие
		$messageModel = MessagingMessage::model()->withMyStatsOnTop($me, false)->findByPk($messageId);
		$message = DialogForm::messageToJson($messageModel, $me, $messageModel->messageUsers[1]->user_id);
		$comet = new CometModel();
		$comet->send($me, array('message' => $message), CometModel::MESSAGING_MESSAGE_DELETED);

	}

    public function actionEdit()
    {
        $messageId = Yii::app()->request->getPost('messageId');
        $text = Yii::app()->request->getPost('text');

        $message = MessagingMessage::model()->with('messageUsers')->findByPk($messageId);
        if ($message && $message->author_id == Yii::app()->user->id && ! $message->isReadByInterlocutor) {
            $message->text = $text;
            $success = $message->save(true, array('text'));
            $response = array(
                'success' => $success,
            );
            echo CJSON::encode($response);
			
			if($success) {
				// Отправим событие
				$comet = new CometModel();
				$comet->send($message->messageUsers[0]->user_id, array('message' => array( 'id' => $message->id, 'text' => $message->text )), CometModel::MESSAGING_MESSAGE_EDITED);
				$comet->send($message->messageUsers[1]->user_id, array('message' => array( 'id' => $message->id, 'text' => $message->text )), CometModel::MESSAGING_MESSAGE_EDITED);
			}
        }
    }

    public function actionCancel()
    {
        $messageId = Yii::app()->request->getPost('messageId');

        $message = MessagingMessage::model()->withMyStatsOnTop(Yii::app()->user->id)->findByPk($messageId);
        if ($message->author_id == Yii::app()->user->id && ! $message->isReadByInterlocutor) {
            $success = $message->delete();
            $response = array(
                'success' => $success,
            );
            echo CJSON::encode($response);
			if($success) {
				// Отправим событие
				$comet = new CometModel();
                $messageData = array(
                    'id' => $message->id,
                    'to_id' => $message->messageUsers[1]->user_id,
                    'from_id' => $message->messageUsers[0]->user_id,
                );
				$comet->send($message->messageUsers[0]->user_id, array('dialog' => array('id' => $message->messageUsers[1]->user_id), 'message' => $messageData), CometModel::MESSAGING_MESSAGE_CANCELLED);
				$comet->send($message->messageUsers[1]->user_id, array('dialog' => array('id' => $message->messageUsers[0]->user_id),'message' => $messageData), CometModel::MESSAGING_MESSAGE_CANCELLED);
			}
        }
    }

    public function actionSend()
    {
        $user = Yii::app()->request->getPost('interlocutorId');
        $text = Yii::app()->request->getPost('text');
		$me = Yii::app()->user->id;
		$thread = MessagingThread::model()->findOrCreate($me, $user);
		$message = MessagingMessage::model()->create($text, $thread->id, $me, array());

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
		}
		
		echo CJSON::encode($data);
		if(!$data['success'])
			Yii::app()->end();

 		// Подготовим и отправим событие
		$comet = new CometModel();
		$messageModel = MessagingMessage::model()->withMyStatsOnTop($me)->findByPk($message->id);
		// Событие себе
		$data = array(
			'dialog' => array(
				'id' => $user,
			),
			'message' => DialogForm::messageToJson($messageModel, $me, $messageModel->messageUsers[1]->user_id, $messageModel->messageUsers[1]),
		);
		$comet->send($me, $data, CometModel::MESSAGING_MESSAGE_ADDED);
		// Событие собеседнику
		$data = array(
			'dialog' => array(
				'id' => $me,
			),
			'message' => DialogForm::messageToJson($messageModel, $messageModel->messageUsers[1]->user_id, $me, $messageModel->messageUsers[1]),
		);
		$comet->send($user, $data, CometModel::MESSAGING_MESSAGE_ADDED);
    }
	
	public function actionReaded()
	{
		$messageId = Yii::app()->request->getParam('messageId');
		$me = Yii::app()->user->id;
        $message = MessagingMessage::model()->findByPk($messageId);
        $messages = MessagingMessage::model()->forMarkAsReaded($messageId, $message->author_id, $me)->findAll(array( 'limit' => 10 ));
		// Выставляем дату прочтения
        $criteria = new CDbCriteria();
        $criteria->addInCondition('message_id', CHtml::listData($messages, 'id', 'id'));
        $criteria->addColumnCondition(array('user_id' => $me));
        MessagingMessageUser::model()->updateAll(array('dtime_read' => new CDbExpression('NOW()')), $criteria);

		echo CJSON::encode(array(
            'success' => true,
        ));

		// Подготовим и отправим событие
		$comet = new CometModel();
        $criteria = new CDbCriteria();
        $criteria->addInCondition('message_id', CHtml::listData($messages, 'id', 'id'));
        $messageModels = MessagingMessage::model()->withMyStatsOnTop($me, false)->findAll($criteria);
        foreach ($messageModels as $messageModel)
        {
            $user = $messageModel->messageUsers[1]->user_id;
            // Событие себе
            $data = array(
                'dialog' => array(
                    'id' => $user,
                ),
                'message' => DialogForm::messageToJson($messageModel, $me, $user, $messageModel->messageUsers[1]),
            );
            $comet->send($me, $data, CometModel::MESSAGING_MESSAGE_READ);
            // Событие собеседнику
            $data = array(
                'dialog' => array(
                    'id' => $me,
                ),
                'message' => DialogForm::messageToJson($messageModel, $user, $me, $messageModel->messageUsers[1]),
            );
            $comet->send($user, $data, CometModel::MESSAGING_MESSAGE_READ);
        }
	}
}