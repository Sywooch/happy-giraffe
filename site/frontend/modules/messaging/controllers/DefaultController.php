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
    public function actionIndex($interlocutorId = null)
    {
        $contacts = ContactsManager::getContactsByUserId(Yii::app()->user->id);
        if ($interlocutorId !== null && ! array_key_exists($interlocutorId, $contacts)) {
            $interlocutor = User::model()->findByPk($interlocutorId);
            $contact = array(
                'user' => array(
                    'id' => (int) $interlocutor->id,
                    'first_name' => $interlocutor->first_name,
                    'last_name' => $interlocutor->last_name,
                    'avatar' => $interlocutor->getAva('small'),
                    'online' => (bool) $interlocutor->online,
                    'isFriend' => (bool) $interlocutor->isFriend(Yii::app()->user->id),
                ),
                'thread' => null,
            );
            $contacts[] = $contact;
        }
        $data = CJSON::encode(compact('contacts', 'interlocutorId'));
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
}
