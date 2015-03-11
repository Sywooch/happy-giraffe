<?php

/**
 * Description of SendCommand
 *
 * @author Кирилл
 */
class SendCommand extends CConsoleCommand
{

    public function actionCommentatorsContest($fromUser = 2, $limit = false)
    {
        Yii::import('site.frontend.modules.messaging.models.*');

        Yii::app()->db->enableSlave = false;
        Yii::app()->db->createCommand('SET SESSION wait_timeout = 28800;')->execute();

        $giraffe = User::model()->findByPk(1);
        $message = <<<MESSAGE
<p>Здраствуйте {name}, испытайте себя в новом конкурсе</p>
<div class="im-message_contest"><a href="http://happy-giraffe.ru/commentatorsContest/1/" class="btn btn-xm btn-link yellow">Принять участие!</a></div>
<p>Желаем успехов!</p>
MESSAGE;

        $dataProvider = new \CActiveDataProvider('User', array('criteria' => array(
                'condition' => '`deleted` = 0 AND `id` >= ' . ((int) $fromUser),
                'order' => 'id ASC',
        )));

        $iterator = new \CDataProviderIterator($dataProvider);
        $count = 0;
        foreach ($iterator as $user) {
            $text = str_replace(
                    array(
                '{name}',
                    ), array(
                $user->first_name,
                    ), $message
            );
            $this->send($giraffe, $user, $text);
            echo '.';
            $count ++;
            if ($limit && $count == $limit) {
                break;
            }
        }
        echo "\ntotal " . $count . " items\n";
    }

    public function send($from, $to, $text)
    {
        $thread = MessagingThread::model()->findOrCreate($from->id, $to->id);
        $message = MessagingMessage::model()->create($text, $thread->id, $from->id, array(), true);
    }

}
