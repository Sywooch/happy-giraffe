

<?php
/**
 * Рассыльщик
 *
 * Отвечает главным образом за то, КОМУ отправлять письма, собирает необходимые для генерации данные и создает модели
 * сообщений
 */

abstract class MailSender extends CComponent
{
    const FROM_NAME = 'Весёлый Жираф';
    const FROM_EMAIL = 'noreply@happy-giraffe.ru';

    const DEBUG_DEVELOPMENT = 0;
    const DEBUG_TESTING = 1;
    const DEBUG_PRODUCTION = 2;

    protected $debugMode = self::DEBUG_DEVELOPMENT;

    /**
     * Отправляет письмо, в случае успеха помечает модель доставки как успешно отправленную
     *
     * @param $email
     * @param $subject
     * @param $body
     * @param $fromEmail
     * @param $fromName
     * @param $deliveryId
     */
    public static function sendEmail($email, $subject, $body, $fromEmail, $fromName, $deliveryId)
    {
        if (ElasticEmail::send($email, $subject, $body, $fromEmail, $fromName)) {
            /** @var MailDelivery $delivery */
            $delivery = MailDelivery::model()->findByPk($deliveryId);
            $delivery->sent();
            echo "sent\n";
        }
    }

    /**
     * Предпросмотр
     *
     * @param User $user
     */
    public function preview(User $user)
    {
        try {
            if ($this->beforeSend()) {
                $this->process($user);
            }
        } catch (CException $e) {
            header('content-type: text/html; charset=utf-8');
            echo $e->getMessage();
        }
    }

    /**
     * Центральный метод отправки сообщения
     *
     * @param MailMessage $message
     */
    protected function sendMessage(MailMessage $message)
    {
        switch ($this->debugMode) {
            case self::DEBUG_DEVELOPMENT:
            case self::DEBUG_TESTING:
                self::sendInternal($message);
                break;
            case self::DEBUG_PRODUCTION:
                $this->addToQueue($message);
                break;
        }
    }

    /**
     * Добавить сообщение в очередь Gearman, используется в продакшне
     *
     * @param MailMessage $message
     */
    protected function addToQueue(MailMessage $message)
    {
        $workload = $this->messageToWorkload($message);

        Yii::app()->gearman->client()->doBackground('sendEmail', serialize($workload));
    }

    protected function sendInternal(MailMessage $message)
    {
        call_user_func_array(array('MailSender', 'sendEmail'), $this->messageToWorkload($message));
    }

    protected function messageToWorkload(MailMessage $message)
    {
        return array(
            'email' => $message->user->email,
            'subject' => $message->getSubject(),
            'body' => $message->getBody(),
            'fromEmail' => self::FROM_EMAIL,
            'fromName' => self::FROM_NAME,
            'deliveryId' => $message->delivery->id,
        );
    }
}