<?php

class ThreadsController extends HController
{

	const MESSAGES_PER_PAGE = 50;

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
	public function actionCreate()
	{
		throw new CHttpException(404);
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
	}

	/**
	 * Изменяет статус видимости диалога
	 *
	 * @throws CHttpException
	 */
	public function actionChangeHiddenStatus()
	{
		throw new CHttpException(404);
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
	public function actionChangeReadStatus()
	{
		throw new CHttpException(404);
		$threadId = Yii::app()->request->getPost('threadId');
		$readStatus = Yii::app()->request->getPost('readStatus');


		$thread = MessagingThread::model()->with('threadUsers')->findByPk($threadId);
		if ($readStatus == 1)
		{
			$messagesCount = $thread->markAsReadFor(Yii::app()->user->id);

			$comet = new CometModel();
			foreach ($thread->threadUsers as $threadUser)
			{
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
	}

	/**
	 * Подгружает выбранный диалог
	 *
	 * @param $threadId
	 * @param int|false $lastDate
	 */
	public function actionGetMessages($userId, $lastDate = false)
	{
		$result = array();
		$me = Yii::app()->user->id;
		$messages = MessagingMessage::model()->between($me, $userId)->withStats(true, $me)->orderDesc();
		if ($lastDate)
		{
			$messages->older($lastDate);
		}
		// Загрузим на одно сообщение больше, что бы узнать последняя ли это страница
		$messages = $messages->findAll(array('limit' => self::MESSAGES_PER_PAGE + 1));
		$result['last'] = sizeof($messages) <= self::MESSAGES_PER_PAGE;
		$count = min(sizeof($messages), self::MESSAGES_PER_PAGE);
		$result['messages'] = array();
		for ($i = 0; $i < $count; $i++)
		{
			$result['messages'][$i] = DialogForm::messageToJson($messages[$i], $me, $userId);
		}

		echo CJSON::encode($result);
	}

	public function actionDelete()
	{
		/** @todo Перенести в модель */
		$me = Yii::app()->user->id;
		$user = Yii::app()->request->getPost('userId');
		$time = time();
		$thread = MessagingThread::model()->findByInterlocutorsIds($me, $user);
		MessagingMessageUser::model()->updateAll(array(
			'dtime_delete' => new CDbExpression('FROM_UNIXTIME(:time)'),
			), 'user_id = :me AND message_id IN (SELECT mm.id FROM `messaging__messages` mm WHERE mm.thread_id = :thread)', array(
			':me' => $me,
			':thread' => $thread->id,
			':time' => $time,
		));

		$response = array(
			'success' => true,
		);
		echo CJSON::encode($response);

		// Подготовим и отправим событие
		$comet = new CometModel();
		$comet->send($me, array(
			'dialog' => array(
				'id' => $user,
				'dtimeDelete' => $time,
			)), CometModel::MESSAGING_THREAD_DELETED);
	}
	
	public function actionRestore()
	{
		/** @todo Перенести в модель */
		$me = Yii::app()->user->id;
		$user = Yii::app()->request->getPost('userId');
		$dtimes = Yii::app()->request->getPost('restore');
		$thread = MessagingThread::model()->findByInterlocutorsIds($me, $user);
		$params = array();
		$in = array();
		$i = 0;
		foreach ($dtimes as $value)
		{
			$k = ':time' . $i;
			$params[$k] = $value;
			$in[] = 'FROM_UNIXTIME(' . $k . ')';
			$i++;
		}
		
		$params[':me'] = $me;
		$params[':thread'] = $thread->id;
		MessagingMessageUser::model()->updateAll(array(
			'dtime_delete' => null,
			), 'user_id = :me AND dtime_delete IN (' . implode(', ', $in) . ') AND message_id IN (SELECT mm.id FROM `messaging__messages` mm WHERE mm.thread_id = :thread)', $params);
		
		$response = array(
			'success' => true,
		);
		echo CJSON::encode($response);

		// Подготовим и отправим событие
		$comet = new CometModel();
		$comet->send($me, array(
			'dialog' => array(
				'id' => $user,
			)), CometModel::MESSAGING_THREAD_RESTORED);
	}
}