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
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'users' => array('@'),
            ),
            array('deny',
                'users' => array('*'),
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

//    public function actionTest()
//    {
//        $randomUsers = User::model()->findAll(array(
//            'limit' => 1000,
//            'order' => new CDbExpression('RAND()'),
//            'condition' => 'id != :me',
//            'params' => array(':me' => 12936),
//        ));
//
//        foreach ($randomUsers as $u) {
//            $thread = new MessagingThread();
//            $threadUser1 = new MessagingThreadUser();
//            $threadUser1->user_id = 12936;
//            $threadUser2 = new MessagingThreadUser();
//            $threadUser2->user_id = $u->id;
//            $thread->threadUsers = array($threadUser1, $threadUser2);
//
//            $thread->withRelated->save(true, array('threadUsers'));
//        }
//    }
//
//    public function actionTest2()
//    {
//        $text = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';
//
//        for ($i = 0; $i < 41; $i++)
//            MessagingMessage::model()->create($i . '. ' . $text, 6558, $i % 2 == 0 ? 10245 : 12936, array());
//    }
//
//    public function actionTest3($id)
//    {
//        $dialog = Dialog::model()->with('dialogUsers', 'messages')->findByPk($id);
//
//        if (! empty($dialog->messages)) {
//            $thread = new MessagingThread();
//            $thread->detachBehavior('CTimestampBehavior');
//
//            $result = array_reduce($dialog->messages, function($l, $r) {
//                $created = strtotime($r->created);
//
//                if ($created < $l['created'])
//                    $l['created'] = $created;
//                if ($created > $l['updated'])
//                    $l['updated'] = $created;
//                return $l;
//            }, array('created' => time(), 'updated' => 0));
//
//            $thread->created = date("Y-m-d H:i:s", $result['created']);
//            $thread->updated = date("Y-m-d H:i:s", $result['updated']);
//
//            $threadUsers = array();
//            foreach ($dialog->dialogUsers as $dialogUser) {
//                $threadUser = new MessagingThreadUser();
//                $threadUser->user_id = $dialogUser->user_id;
//                $threadUsers[] = $threadUser;
//            }
//            $thread->threadUsers = $threadUsers;
//
//            $messages = array();
//            foreach ($dialog->messages as $m) {
//                $message = new MessagingMessage();
//                $message->detachBehavior('CTimestampBehavior');
//                $message->author_id = $m->user_id;
//                $message->text = $m->text;
//                $message->created = $m->created;
//                $message->updated = $m->created;
//                $messageUsers = array();
//                foreach ($dialog->dialogUsers as $dialogUser) {
//                    $messageUser = new MessagingMessageUser();
//                    $messageUser->user_id = $dialogUser->user_id;
//                    $messageUser->read = $dialogUser->user_id == $m->user_id ? null : 1;
//                    $messageUsers[] = $messageUser;
//                }
//                $message->messageUsers = $messageUsers;
//                $messages[] = $message;
//            }
//            $thread->messages = $messages;
//
//            $thread->withRelated->save(true, array(
//                'threadUsers',
//                'messages' => array(
//                    'messageUsers',
//                ),
//            ));
//        }
//    }
//
//    public function actionTest4()
//    {
//        $id = Yii::app()->request->getQuery('id');
//        $message = MessagingMessage::model()->findByPk($id);
//        var_dump($message->json);
//    }
}
