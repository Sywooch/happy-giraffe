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
    public $tempLayout = true;

    public function actionIndex($interlocutorId = null)
    {
        $contacts = ContactsManager::getContactsByUserId(Yii::app()->user->id);
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
                        'isFriend' => (bool) $interlocutor->isFriend(Yii::app()->user->id),
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
        );

        $data = CJSON::encode(compact('contacts', 'interlocutorId', 'me', 'settings'));
        $this->render('index', compact('data'));
    }

    public function actionTest()
    {
        $randomUsers = User::model()->findAll(array(
            'limit' => 100,
            'order' => new CDbExpression('RAND()'),
        ));

        foreach ($randomUsers as $u) {
            $thread = new MessagingThread();
            $threadUser1 = new MessagingThreadUser();
            $threadUser1->user_id = 12936;
            $threadUser2 = new MessagingThreadUser();
            $threadUser2->user_id = $u->id;
            $thread->threadUsers = array($threadUser1, $threadUser2);

            $thread->withRelated->save(true, array('threadUsers'));
        }
    }

    public function actionTest2()
    {
        $text = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';

        for ($i = 0; $i < 41; $i++)
            MessagingMessage::model()->create($i . '. ' . $text, 1245, $i % 2 == 0 ? 22 : 12936);
    }
}
