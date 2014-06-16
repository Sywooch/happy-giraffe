<?php
/**
 * Команда для отправки рассылок
 *
 * Список поддерживаемых рассылок:
 * dialogues - новые непрочитанные сообщения
 */

class DefaultCommand extends CConsoleCommand
{
    /**
     * Инициализаия
     *
     * Создается экземпляр класса MailModule для того, чтобы выполнился импорт классов модуля
     */
    public function init()
    {
        Yii::import('site.frontend.modules.mail.MailModule');
        MailModule::externalImport();
    }

    /**
     * Отправка рассылки о новых непрочитанных сообщениях
     */
    public function actionDialogues()
    {
        $sender = new MailSenderDialogues();
        $sender->sendAll();
    }

    /**
     * Отправка ежедневной рассылки
     */
    public function actionDaily()
    {
        $sender = new MailSenderDaily();
        $sender->sendAll();
    }

    public function actionNotificationsComment()
    {
        $sender = new MailSenderNotification(MailSenderNotification::TYPE_COMMENT);
        $sender->sendAll();
    }

    public function actionNotificationsDiscuss()
    {
        $sender = new MailSenderNotification(MailSenderNotification::TYPE_DISCUSS);
        $sender->sendAll();
    }

    public function actionNotificationsReply()
    {
        $sender = new MailSenderNotification(MailSenderNotification::TYPE_REPLY);
        $sender->sendAll();
    }

    public function actionTest()
    {
        $user = User::model()->findByPk(12936);
        $message = new MailMessageTest($user);
        Yii::app()->postman->send($message, MailPostman::MODE_QUEUE);
    }

    public function actionTestWarning()
    {
        Yii::log('Test warning', CLogger::LEVEL_ERROR, 'mail');
    }

    public function actionTestComet($pos = 0)
    {
        $a = Yii::app()->comet->cmdWatch($pos, 'onOff');
        print_r($a);
    }

    public function actionWorker()
    {
        Yii::import('site.frontend.extensions.status.*');
        Yii::import('zii.behaviors.*');
        Yii::import('site.frontend.extensions.geturl.*');
        Yii::import('site.common.extensions.wr.*');

        Yii::app()->gearman->worker()->addFunction('sendEmail', function($job) {
            $message = unserialize($job->workload());
            $postman = Yii::app()->postman;
            call_user_func_array(array($postman, 'sendEmail'), $message);
        });
        while (Yii::app()->gearman->worker()->work()) {
            echo "OK\n";
        }
    }
}