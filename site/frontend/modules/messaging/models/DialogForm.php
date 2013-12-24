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
	public $interlocutor;
	public $counters;
	public $me;
	public $settings;

	public function __construct($interlocutorId = null)
	{
		$this->contacts = ContactsManager::getContactsByUserId(Yii::app()->user->id, ContactsManager::TYPE_ALL, self::CONTACTS_PER_PAGE);

		$this->counters = array(
			(int) ContactsManager::getCountByType(Yii::app()->user->id, ContactsManager::TYPE_NEW),
			(int) ContactsManager::getCountByType(Yii::app()->user->id, ContactsManager::TYPE_ONLINE),
			(int) ContactsManager::getCountByType(Yii::app()->user->id, ContactsManager::TYPE_FRIENDS_ONLINE),
		);

		if ($interlocutorId !== null)
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
				$this->contact = array(
					'id' => (int) $interlocutor->id,
					'firstName' => $interlocutor->first_name,
					'lastName' => $interlocutor->last_name,
					'gender' => $interlocutor->gender,
					'avatar' => $interlocutor->getAvatarUrl(Avatar::SIZE_MICRO),
					'online' => (bool) $interlocutor->online,
					'isFriend' => (bool) Friend::model()->areFriends(Yii::app()->user->id, $interlocutorId),
				);
				$this->contacts[] = $contact;
			}
		}

		$this->me = array(
			'id' => (int) Yii::app()->user->model->id,
			'firstName' => Yii::app()->user->model->first_name,
			'lastName' => Yii::app()->user->model->last_name,
			'gender' => (bool) Yii::app()->user->model->gender,
			'avatar' => Yii::app()->user->model->getAvatarUrl(Avatar::SIZE_MICRO),
			'online' => (bool) Yii::app()->user->model->online,
			'isFriend' => null,
		);

		$this->settings = array(
			'messaging__enter' => (bool) UserAttributes::get(Yii::app()->user->id, 'messaging__enter', false),
			'messaging__sound' => (bool) UserAttributes::get(Yii::app()->user->id, 'messaging__sound', true),
			'messaging__interlocutorExpanded' => (bool) UserAttributes::get(Yii::app()->user->id, 'messaging__interlocutorExpanded', true),
			'messaging__blackList' => (bool) UserAttributes::get(Yii::app()->user->id, 'messaging__blackList', false),
		);

		$data = CJSON::encode(compact('contacts', 'interlocutorId', 'me', 'settings', 'counters'));
	}

	public function toJSON()
	{
		return array(
			'contacts' => $this->contacts,
			'interlocutor' => $this->interlocutor,
			'counters' => $this->counters,
			'me' => $this->me,
			'settings' => $this->settings,
		);
	}

}

?>
