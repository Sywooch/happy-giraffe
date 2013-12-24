<?php

class ThreadsController extends HController
{
    const MESSAGES_PER_PAGE = 20;

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

    /**
     * Создание диалога
     *
     * Создает новый диалог с указанным собеседником
     */
    /*public function actionCreate()
    {
        $interlocutor_id = Yii::app()->request->getPost('interlocutor_id');

        $thread = new MessagingThread();
        $threadUser1 = new MessagingThreadUser();
        $threadUser1->user_id = Yii::app()->user->id;
        $threadUser2 = new MessagingThreadUser();
        $threadUser2->user_id = $interlocutor_id;
        $thread->threadUsers = array($threadUser1, $threadUser2);

        $success = $thread->withRelated->save(true, array('threadUsers'));
        $response = array(
            'success' => $success,
        );
        echo CJSON::encode($response);
    }*/

    /**
     * Изменяет статус видимости диалога
     *
     * @throws CHttpException
     */
    public function actionChangeHiddenStatus()
    {
        $threadId = Yii::app()->request->getPost('threadId');
        $hiddenStatus = Yii::app()->request->getPost('hiddenStatus');

        $threadUser = MessagingThreadUser::model()->findByAttributes(array(
            'thread_id' => $threadId,
            'user_id' => Yii::app()->user->id,
        ));

        if ($threadUser === null)
            throw new CHttpException(403, 'Thread does not exists.');

        $threadUser->hidden = $hiddenStatus;

        $success = $threadUser->save();
        $response = array(
            'success' => $success,
        );
        echo CJSON::encode($response);
    }

    /**
     * Изменяет статус прочитанности диалога
     */
    /*public function actionChangeReadStatus()
    {
        $threadId = Yii::app()->request->getPost('threadId');
        $readStatus = Yii::app()->request->getPost('readStatus');


        $thread = MessagingThread::model()->with('threadUsers')->findByPk($threadId);
        if ($readStatus == 1) {
            $messagesCount = $thread->markAsReadFor(Yii::app()->user->id);

            $comet = new CometModel();
            foreach ($thread->threadUsers as $threadUser) {
                if ($threadUser->user_id !== Yii::app()->user->id)
                    $comet->send($threadUser->user_id, array('threadId' => $threadId), CometModel::MESSAGING_THREAD_READ);
            }
        }
        else
            $messagesCount = $thread->markAsUnReadFor(Yii::app()->user->id);

        $response = array(
            'success' => $messagesCount > 0,
            'messagesCount' => $messagesCount,
        );
        echo CJSON::encode($response);
    }*/

    /**
     * Подгружает выбранный диалог
     *
     * @param $threadId
     * @param int $offset
     */
    public function actionGetMessages($userId, $lastDate = false)
    {
		$result = array();
		$me = Yii::app()->user->id;
        $messages = MessagingMessage::model()->between($me, $userId)->withMyStats($me);
		if($lastDate) {
			$messages->older($lastDate);
		}
		// Загрузим на одно сообщение больше, что бы узнать последняя ли это страница
		$messages = $messages->findAll(array( 'limit' => self::MESSAGES_PER_PAGE + 1 ));
		$result['last'] = sizeof($messages) <= self::MESSAGES_PER_PAGE;
		$count = min(sizeof($messages), self::MESSAGES_PER_PAGE);
		for($i = 0; $i < $count; $i++) {
			$message = $messages[$i];
			$result['messages'][$i] = array(
				'id' => $message->id,
				'from_id' => $message->author_id,
				'to_id' => $message->author_id == $me ? $userId : $me,
				'text' => $message->text,
				'created' => $message->created,
				'dtimeRead' => $message->messageUsers[0]->dtime_read,
				'dtimeDelete' => $message->messageUsers[0]->dtime_delete,
			);
		}
		
        echo CJSON::encode($result);
    }

    public function actionDeleteMessages()
    {
        $threadId = Yii::app()->request->getPost('threadId');

        $thread = MessagingThread::model();
        $thread->id = $threadId;

        $thread->deleteMessagesFor(Yii::app()->user->id);

        $response = array(
            'success' => true,
        );
        echo CJSON::encode($response);
    }
}