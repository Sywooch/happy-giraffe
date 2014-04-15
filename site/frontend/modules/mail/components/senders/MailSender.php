

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

    const DEBUG_DEVELOPMENT = 0;
    const DEBUG_TESTING = 1;
    const DEBUG_PRODUCTION = 2;

    protected $debugMode = self::DEBUG_DEVELOPMENT;

    protected abstract function process(User $user);

    /**
     * Отправить рассылку всем пользователям, для которых она может быть отправлена
     *
     * Может быть перопределен, если до или после итерации необходимо выполнить какие-то действия
     *
     * @return mixed
     */
    public function sendAll()
    {
        $this->iterate();
    }

    /**
     * Отправляет сообщение, в случае успеха помечает модель доставки как успешно отправленную
     *
     * @param MailMessage $message
     */
    public static function sendInternal($email, $subject, $body, $fromEmail, $fromName, $deliveryId)
    {
        if (ElasticEmail::send($email, $subject, $body, $fromEmail, $fromName)) {
            $delivery = MailDelivery::model()->findByPk($deliveryId);
            $delivery->sent();
            echo "sent\n";
        }
    }

    /**
     * Возвращает итератор на основе критерии
     *
     * @return CDataProviderIterator
     */
    protected function getIterator()
    {
        $dp = new CActiveDataProvider('User', array(
            'criteria' => $this->getUsersCriteria(),
        ));
        return new CDataProviderIterator($dp, 1000);
    }

    /**
     * Критерия для выборки пользователей
     *
     * Позволяет уже на этапе выборке отсечь лишних пользователей, что оптимизирует генерацию рассылки и упрощает
     * сам код рассылки (нет необходимости проверять значения полей, по которым итератор уже отфильтрован)
     *
     * @return CDbCriteria
     */
    protected function getUsersCriteria()
    {
        $criteria = new CDbCriteria();

        switch ($this->debugMode) {
            case self::DEBUG_DEVELOPMENT:
                $criteria->compare('t.id', 12936);
                break;
            case self::DEBUG_TESTING:
                $criteria->compare('`group`', UserGroup::COMMENTATOR);
                break;
        }

        return $criteria;
    }

    /**
     * Процедура итерации
     *
     * Вынесена отдельно, чтобы можно было удобно переопределять метод sendAll
     */
    protected function iterate()
    {
        $iterator = $this->getIterator();
        foreach ($iterator as $user) {
            $result = $this->process($user);
            if ($result instanceof MailMessage)
                $this->addToQueue($result);
        }
    }

    protected function addToQueue(MailMessage $message)
    {
        $workload = array(
            'email' => $message->user->email,
            'subject' => $message->getSubject(),
            'body' => $message->getBody(),
            'fromEmail' => self::FROM_EMAIL,
            'fromName' => self::FROM_NAME,
            'deliveryId' => $message->delivery->id,
        );

        Yii::app()->gearman->client()->doBackground('sendEmail', serialize($workload));
    }
}