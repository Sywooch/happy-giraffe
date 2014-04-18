

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
     * Обработка конкретно взятого пользователя. Если для него нужно создавать сообщение, возвращает экземпляр класса
     * MailMessage, в противном случае null
     *
     * @param User $user
     * @return mixed
     */
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
        if ($this->beforeSend()) {
            $this->iterate();
        }
    }

    public function showForUser(User $user)
    {
        if ($this->beforeSend()) {
            $message = $this->process($user);
            echo $message->getBody();
        }
    }

    /**
     * Отправляет сообщение, в случае успеха помечает модель доставки как успешно отправленную
     *
     * @param $email
     * @param $subject
     * @param $body
     * @param $fromEmail
     * @param $fromName
     * @param $deliveryId
     */
    public static function send($email, $subject, $body, $fromEmail, $fromName, $deliveryId)
    {
        if (ElasticEmail::send($email, $subject, $body, $fromEmail, $fromName)) {
            $delivery = MailDelivery::model()->findByPk($deliveryId);
            $delivery->sent();
            echo "sent\n";
        }
    }

    protected function beforeSend()
    {
        return true;
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
                $criteria->join = 'INNER JOIN auth__assignments aa ON aa.userid = t.id AND aa.itemname = :itemname';
                $criteria->params[':itemname'] = 'tester';
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
            if ($result instanceof MailMessage) {
                if (Yii::app() instanceof CWebApplication) {
                    echo $result->getBody();
                }
                else {
                    switch ($this->debugMode) {
                        case self::DEBUG_DEVELOPMENT:
                        case self::DEBUG_TESTING:
                            self::sendInternal($result);
                            break;
                        case self::DEBUG_PRODUCTION:
                            $this->addToQueue($result);
                            break;
                    }
                }
            }
        }
    }

    protected function addToQueue(MailMessage $message)
    {
        $workload = $this->messageToWorkload($message);

        Yii::app()->gearman->client()->doBackground('sendEmail', serialize($workload));
    }

    protected function sendInternal(MailMessage $message)
    {
        call_user_func_array(array('MailSender', 'send'), $this->messageToWorkload($message));
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