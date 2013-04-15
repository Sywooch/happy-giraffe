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

        $data = CJSON::encode(compact('contacts', 'interlocutorId', 'me'));
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
        for ($i = 0; $i < 40; $i++) {
            MessagingMessage::model()->create(time(), 1113, $i % 2 == 0 ? 22 : 12936);
            sleep(1);
        }
    }
}
