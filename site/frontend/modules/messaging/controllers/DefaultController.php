<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 3/28/13
 * Time: 2:00 PM
 * To change this template use File | Settings | File Templates.
 */
class DefaultController extends HController
{
    const CONTACTS_PER_PAGE = 50;

    public $tempLayout = true;

    public function filters()
    {
        return array(
            'accessControl',
            'ajaxOnly - index',
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

    public function actionIndex($interlocutorId = null)
    {
        $contacts = ContactsManager::getContactsByUserId(Yii::app()->user->id, ContactsManager::TYPE_ALL, self::CONTACTS_PER_PAGE);

        $counters = array(
            (int) ContactsManager::getCountByType(Yii::app()->user->id, ContactsManager::TYPE_NEW),
            (int) ContactsManager::getCountByType(Yii::app()->user->id, ContactsManager::TYPE_ONLINE),
            (int) ContactsManager::getCountByType(Yii::app()->user->id, ContactsManager::TYPE_FRIENDS_ONLINE),
        );

        if ($interlocutorId !== null) {
            $interlocutorExist = false;
            foreach ($contacts as $contact) {
                if ($contact['user']['id'] == $interlocutorId) {
                    $interlocutorExist = true;
                    break;
                }
            }
            if (! $interlocutorExist) {
                $interlocutor = User::model()->findByPk($interlocutorId);
                $contact = array(
                    'user' => array(
                        'id' => (int) $interlocutor->id,
                        'firstName' => $interlocutor->first_name,
                        'lastName' => $interlocutor->last_name,
                        'gender' => $interlocutor->gender,
                        'avatar' => $interlocutor->getAva('small'),
                        'online' => (bool) $interlocutor->online,
                        'isFriend' => (bool) Friend::model()->areFriends(Yii::app()->user->id, $interlocutorId),
                    ),
                    'thread' => null,
                );
                $contacts[] = $contact;
            }
        }

        $me = array(
            'id' => (int) Yii::app()->user->model->id,
            'firstName' => Yii::app()->user->model->first_name,
            'lastName' => Yii::app()->user->model->last_name,
            'gender' => (bool) Yii::app()->user->model->gender,
            'avatar' => Yii::app()->user->model->getAva('small'),
            'online' => (bool) Yii::app()->user->model->online,
            'isFriend' => null,
        );

        $settings = array(
            'messaging__enter' => (bool) UserAttributes::get(Yii::app()->user->id, 'messaging__enter', false),
            'messaging__sound' => (bool) UserAttributes::get(Yii::app()->user->id, 'messaging__sound', true),
            'messaging__interlocutorExpanded' => (bool) UserAttributes::get(Yii::app()->user->id, 'messaging__interlocutorExpanded', true),
            'messaging__blackList' => (bool) UserAttributes::get(Yii::app()->user->id, 'messaging__blackList', false),
        );

        $data = CJSON::encode(compact('contacts', 'interlocutorId', 'me', 'settings', 'counters'));
        $this->pageTitle = 'Мои диалоги';
        $this->render('index', compact('data'));
    }

    public function actionGetContacts($type, $offset = 0)
    {
        $contacts = ContactsManager::getContactsByUserId(Yii::app()->user->id, $type, self::CONTACTS_PER_PAGE, $offset);
        $data = compact('contacts');
        echo CJSON::encode($data);
    }
}
