

<?php
/**
 * Рассыльщик
 *
 * Отвечает главным образом за то, КОМУ отправлять письма, собирает необходимые для генерации данные и передает их
 * в модель сообщения
 */

abstract class MailSender extends CComponent
{
    const FROM_NAME = 'Весёлый Жираф';
    const FROM_EMAIL = 'noreply@happy-giraffe.ru';
    const SENDER_DEBUG = true;

    public $messagesBuffer = array();
    protected abstract function process(User $user);

    /**
     * Отправить рассылку всем пользователям, для которых она может быть отправлена
     *
     * @return mixed
     */
    public function sendAll()
    {
        $criteria = new CDbCriteria();
        $criteria->compare('`group`', UserGroup::COMMENTATOR);
        $criteria->compare('t.id', 12936);

        $dp = new CActiveDataProvider('User', array(
            'criteria' => $criteria,
        ));
        $iterator = new CDataProviderIterator($dp, 1000);

        if (self::SENDER_DEBUG) {
            foreach ($iterator as $user) {
                $result = $this->process($user);

                if ($result instanceof MailMessage)
                    $this->messagesBuffer[] = $result;

                if (count($this->messagesBuffer) == 1000)
                    $this->sendBufferedMessages();
            }
            $this->sendBufferedMessages();
        } else {
            foreach ($iterator as $user) {
                $result = $this->process($user);
                $this->sendInternal($result);
            }
        }
    }

    /**
     * Отправляет сообщение, в случае успеха помечает модель доставки как успешно отправленную
     *
     * @param MailMessage $message
     */
    protected function sendInternal(MailMessage $message)
    {
        if (ElasticEmail::send($message->user->email, $message->getSubject(), $message->getBody(), self::FROM_EMAIL, self::FROM_NAME)) {
            $message->delivery->sent();
            echo "sent\n";
        }
    }

    protected function sendInternalBatch(array $messages)
    {
        if (empty($messages))
            return;

        $csv  = '"ToMail","Body","Subject"' . "\n";
        foreach ($messages as $message) {
            $html = $message->getBody();
            $html = str_replace('"', '"', $html);
            $html = str_replace(array("\n", "\r", "\r\n", "\n\r"), '', $html);
            $csv .= '"' . implode('","', array($message->user->email, $html, $message->getSubject())) . '"' . "\n";
            $csv .= '"' . implode('","', array('andrey@happy-giraffe.ru', $html, $message->getSubject())) . '"' . "\n";
        }

        $response = ElasticEmail::mailMerge($csv, self::FROM_EMAIL, self::FROM_NAME, '{Subject}', null, '{Body}');
        echo $response;
        if ($response) {
            foreach ($messages as $message) {
                $message->delivery->sent();
            }
            echo "sent\n";
        }
    }

    protected function sendBufferedMessages()
    {
        $this->sendInternalBatch($this->messagesBuffer);
    }
}