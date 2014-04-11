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
        new MailModule('mail', null);
        parent::init();
    }

    /**
     * Отправка рассылки о новых непрочитанных сообщениях
     */
    public function actionDialogues()
    {
        $sender = new MailSenderDialogues();
        $sender->sendAll();
    }

    public function actionTestWarning()
    {
        Yii::log('Test warning', CLogger::LEVEL_ERROR, 'mail');
    }
}