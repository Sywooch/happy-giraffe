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
        \Yii::app()->db->enableSlave = false;
        \Yii::app()->db->createCommand('SET SESSION wait_timeout = 28800;')->execute();
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

    public function actionGeneric($tpl)
    {
        $sender = new MailSenderGeneric($tpl);
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
        $sender = new MailSenderTest();
        $sender->sendAll();
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
        Yii::import('site.frontend.extensions.status.EStatusBehavior');
        Yii::import('zii.behaviors.CTimestampBehavior');
        Yii::import('site.frontend.extensions.geturl.EGetUrlBehavior');
        Yii::import('site.common.extensions.wr.WithRelatedBehavior');
        Yii::import('site.frontend.modules.mail.components.MailPostman');

        Yii::app()->gearman->worker()->addFunction('sendEmail', function($job) {
            $message = unserialize($job->workload());
            if ($message->type != '') {
                call_user_func_array(array(Yii::app()->postman, 'sendEmail'), array($message));
            }
        });
        while (Yii::app()->gearman->worker()->work()) {
            echo "OK\n";
        }
    }
}