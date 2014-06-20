<?php
/**
 * Компонент, выполняющий роль "почтальона"
 *
 * Этот класс отвечает за доставку сообщения (объект типа MailMessage) конечному пользователю. Сами сообщения
 * генерируются за пределами компонента, в основном в объектах типа MailSender
 */

class MailPostman extends CApplicationComponent
{
    const FROM_NAME = 'Весёлый Жираф';
    const FROM_EMAIL = 'noreply@happy-giraffe.ru';

    const MODE_SIMPLE = 0;
    const MODE_QUEUE = 1;
    const MODE_ECHO = 2;

    public $mode = self::MODE_SIMPLE;

    /**
     * Центральный метод отправки сообщения
     *
     * @param MailMessage $message
     */
    public function send(MailMessage $message, $mode = null)
    {
        $mode = $mode === null ? $this->mode : $mode;

        switch ($mode) {
            case self::MODE_ECHO:
                echo $message->getBody();
                break;
            case self::MODE_QUEUE:
                $this->addToQueue($message);
                break;
            case self::MODE_SIMPLE:
                $this->sendEmail($message);
                break;
        }

        return true;
    }

    /**
     * Отправляет письмо, в случае успеха помечает модель доставки как успешно отправленную
     *
     * @param MailMessage $message
     */
    public function sendEmail(MailMessage $message)
    {
        ElasticEmail::send($message->user->email, $message->getSubject(), $message->getBody(), self::FROM_EMAIL, self::FROM_NAME);
    }

    /**
     * Добавить сообщение в очередь Gearman, используется в продакшне
     *
     * @param MailMessage $message
     */
    public function addToQueue(MailMessage $message)
    {
        Yii::app()->gearman->client()->doBackground('sendEmail', serialize($message));
    }
}