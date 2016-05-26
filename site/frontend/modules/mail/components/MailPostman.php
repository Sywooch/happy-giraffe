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

    /**
     * небольшое не самое лучше решение, но в стиле предидущих разработчиков,
     * список шаблонов которые используют транзакционный профиль рассылки без
     * возможности отписаться
     * @var array
     */
    private $transactionalDeliver = array('test', 'dialogues', 'passwordRecovery', 'confirmEmail');

    public $mode = self::MODE_QUEUE;

    /**
     * Центральный метод отправки сообщения
     *
     * @param MailMessage $message
     */
    public function send(MailMessage $message)
    {
        if ($this->mode == self::MODE_SIMPLE)
        {
            $this->sendEmail($message);
        }
        else
        {
            $this->addToQueue($message);
        }
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

    /**
     * Отправляет письмо, в случае успеха помечает модель доставки как успешно отправленную
     *
     * @param MailMessage $message
     */
    public function sendEmail(MailMessage $message)
    {
        $flag = false;
        if (in_array($message->type, $this->transactionalDeliver))
        {
            $flag = ElasticEmailTransactional::send($message->user->email, $message->getSubject(), $message->getBody(), self::FROM_EMAIL, self::FROM_NAME);
        }
        else
        {
            $flag = ElasticEmail::send($message->user->email, $message->getSubject(), $message->getBody(), self::FROM_EMAIL, self::FROM_NAME);
        }
        if ($flag)
        {
            $message->delivery->sent();
        }
    }

}
