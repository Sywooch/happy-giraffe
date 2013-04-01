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
    public function actionIndex()
    {
        $contacts = ContactsManager::getContactsByUserId(Yii::app()->user->id);
        echo CJSON::encode($contacts);
    }

    public function actionTest()
    {
        $randomUsers = User::model()->findAll(array(
            'limit' => 1000,
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
