<?php

/**
 * Модель, отражающая структуру диалогов
 *
 * @author Кирилл
 */
class DialogForm extends CComponent
{

	const CONTACTS_PER_PAGE = 50;

	public $contacts;
	//public $interlocutor;
	public $counters;
	public $me;
	public $settings;

	public function __construct($interlocutorId = null)
	{
		$this->contacts = ContactsManager::getContactsByUserId(Yii::app()->user->id, ContactsManager::TYPE_ALL, self::CONTACTS_PER_PAGE);

		$this->counters = array(
			'total' => (int) ContactsManager::getCountByType(Yii::app()->user->id, ContactsManager::TYPE_NEW),
		);

		/* if ($interlocutorId !== null)
		  {
		  $interlocutorExist = false;
		  foreach ($contacts as $contact)
		  {
		  if ($contact['user']['id'] == $interlocutorId)
		  {
		  $interlocutorExist = true;
		  break;
		  }
		  }
		  if (!$interlocutorExist)
		  {
		  $this->interlocutor = User::model()->findByPk($interlocutorId);
		  $this->contact = self::userToJson($interlocutor);
		  $this->contacts[] = $contact;
		  }
		  } */

		$this->me = self::userToJson(Yii::app()->user->model);

		$this->settings = array(
			'messaging__enter' => (bool) UserAttributes::get(Yii::app()->user->id, 'messaging__enter', false),
			'messaging__sound' => (bool) UserAttributes::get(Yii::app()->user->id, 'messaging__sound', true),
			'messaging__interlocutorExpanded' => (bool) UserAttributes::get(Yii::app()->user->id, 'messaging__interlocutorExpanded', true),
			'messaging__blackList' => (bool) UserAttributes::get(Yii::app()->user->id, 'messaging__blackList', false),
		);

	}

	public function toJSON()
	{
		return array(
			'contacts' => $this->contacts,
			//'interlocutor' => $this->interlocutor,
			'counters' => $this->counters,
			'me' => $this->me,
			'settings' => $this->settings,
		);
	}

	/**
	 * Преобразование модели пользователя в массив, для использования
	 * в JS-модели MessagingUser
	 * 
	 * @param User $user
	 * 
	 * @return array Массив, пригодный для преобразования в JSON
	 */
	public static function userToJson(User $user)
	{
		/** @todo Практически идентичная функциональность с ContactsManager::populateContact */
		return array(
			'id' => (int) $user->id,
			'firstName' => $user->first_name,
			'lastName' => $user->last_name,
			'gender' => (bool) $user->gender,
			'avatar' => $user->getAvatarUrl(Avatar::SIZE_MEDIUM),
			'isOnline' => (bool) $user->online,
			'lastOnline' => self::parseDateTime($user->last_active),
			'isFriend' => null,
		);
	}

	/**
	 * Преобразование модели сообщения в массив, для использования
	 * в JS-модели MessagingMessage
	 * 
	 * @param MessagingMessage $message Модель сообщения, где в messageUsers[0]
	 * должна находится запись отношения просматривающего пользователя к сообщению,
	 * или это отношение должно быть передано в $messageUser
	 * @param int $me Id пользователя, просматривающего сообщение
	 * @param int $interlocutor Id пользователя, с которым ведётся диалог
	 * @param MessagingMessageUser $messageUser модель пользователя, для которого готовятся данные
	 * 
	 * @return array Массив, пригодный для преобразования в JSON
	 */
	public static function messageToJson(MessagingMessage $message, $me, $interlocutor, $messageUser = false)
	{
		// есть $message->json, посмотреть, при работе с изображениями
		return array(
			'id' => $message->id,
			'from_id' => $message->author_id,
			'to_id' => $message->author_id == $me ? $interlocutor : $me,
			'text' => $message->text,
			'created' => self::parseDateTime($message->created),
			'dtimeRead' => $messageUser ? self::parseDateTime($messageUser->dtime_read) : self::parseDateTime($message->messageUsers[0]->dtime_read),
			'dtimeDelete' => $messageUser ? self::parseDateTime($messageUser->dtime_delete) : self::parseDateTime($message->messageUsers[0]->dtime_delete),
		);
	}

	/**
	 * Преобразует дату, взятую из базы, в дату, пригодную для отправки в js
	 * 
	 * @param string|null $dtime
	 * @return int|null
	 */
	public static function parseDateTime($dtime)
	{
		return is_null($dtime) ? null : strtotime($dtime);
	}

}

?>
