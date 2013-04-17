<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 4/17/13
 * Time: 1:32 PM
 * To change this template use File | Settings | File Templates.
 */
class MessagingCommand extends CConsoleCommand
{
    public function init()
    {
        Yii::import('site.frontend.modules.im.models.*');
        Yii::import('site.frontend.modules.messaging.models.*');
    }

    public function actionConvert()
    {
        DialogUser::model()->deleteAll('user_id IS NULL');
        Message::model()->deleteAll('user_id IS NULL');
        $dataProvider = new CActiveDataProvider('Dialog', array(
            'criteria' => array(
                'with' => array(
                    'dialogUsers',
                    'messages',
                ),
                'order' => 't.id',
            ),
        ));

        $iterator = new CDataProviderIterator($dataProvider, 1000);
        foreach ($iterator as $dialog) {
            if (! empty($messages))
                $this->_process($dialog);
        }
    }

    private function _process($dialog)
    {
        $thread = new MessagingThread();
        $thread->detachBehavior('CTimestampBehavior');

        $result = array_reduce($dialog->messages, function($l, $r) {
            $created = strtotime($r->created);

            if ($created < $l['created'])
                $l['created'] = $created;
            if ($created > $l['updated'])
                $l['updated'] = $created;
            return $l;
        }, array('created' => time(), 'updated' => 0));

        $thread->created = date("Y-m-d H:i:s", $result['created']);
        $thread->updated = date("Y-m-d H:i:s", $result['updated']);

        $threadUsers = array();
        foreach ($dialog->dialogUsers as $dialogUser) {
            $threadUser = new MessagingThreadUser();
            $threadUser->user_id = $dialogUser->user_id;
            $threadUsers[] = $threadUser;
        }
        $thread->threadUsers = $threadUsers;

        $messages = array();
        foreach ($dialog->messages as $m) {
            $message = new MessagingMessage();
            $message->detachBehavior('CTimestampBehavior');
            $message->author_id = $m->user_id;
            $message->text = $m->text;
            $message->created = $m->created;
            $message->updated = $m->created;
            $messageUsers = array();
            foreach ($dialog->dialogUsers as $dialogUser) {
                $messageUser = new MessagingMessageUser();
                $messageUser->user_id = $dialogUser->user_id;
                $messageUser->read = $dialogUser->user_id == $m->user_id ? null : 1;
                $messageUsers[] = $messageUser;
            }
            $message->messageUsers = $messageUsers;
            $messages[] = $message;
        }
        $thread->messages = $messages;

        if ($thread->withRelated->save(true, array(
            'threadUsers',
            'messages' => array(
                'messageUsers',
            ),
        )))
            echo 'Thread ' . $thread->id . ' has been successfully saved.';
        else
            echo 'Thread ' . $thread->id . ' has not been saved';
    }
}
