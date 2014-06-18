<?php
/**
 * Рассыльщик
 *
 * Отвечает главным образом за то, КОМУ отправлять письма, собирает необходимые для генерации данные, создает модели
 * сообщений и передает их "почтальону" MailPostman
 */

Yii::import('site.common.models.mongo.UserAttributes');

abstract class MailSender extends CComponent
{
    const DEBUG_DEVELOPMENT = 0;
    const DEBUG_TESTING = 1;
    const DEBUG_PRODUCTION = 2;

    public $type;

    protected $processStartTimestmap;
    protected $lastDeliveryTimestamp;
    protected $debugMode = self::DEBUG_DEVELOPMENT;
    protected $percent = 100;

    /**
     * Обработка конкретно взятого пользователя
     *
     * @param User $user
     * @return mixed
     */
    protected abstract function process(User $user);

    /**
     * Отправить рассылку всем пользователям, для которых она может быть отправлена
     *
     * @return mixed
     */
    public function sendAll()
    {
        try {
            if ($this->beforeSend()) {
                $this->iterate();
            }
        } catch (Exception $e) {
            //echo $e->getMessage();
            //Yii::log($e->getMessage(), CLogger::LEVEL_ERROR, 'mail');
        }
    }

    public function preview(User $user)
    {
        /** @var MailPostman $postman */
        $postman = Yii::app()->postman;
        $mode = $postman->mode;
        $postman->mode = MailPostman::MODE_ECHO;

        try {
            if ($this->beforeSend()) {
                $this->processInternal($user);
            }
        } catch (Exception $e) {
            header('Content-Type: text/html; charset=utf-8');
            echo $e->getMessage();
            Yii::log($e->getMessage(), CLogger::LEVEL_ERROR, 'mail');
        }
    }

    protected function send(MailMessage $message)
    {
        /** @var MailPostman $postman */
        $postman = Yii::app()->postman;
        if ($postman->send($message)) {
            $message->sent();
        }
    }

    protected function processInternal(User $user)
    {
        $this->processStartTimestmap = time();
        $this->process($user);
    }

    protected function getDeliveryType()
    {
        return $this->type;
    }

    /**
     * Процедура итерации
     *
     * Вынесена отдельно, чтобы можно было удобно переопределять метод sendAll
     */
    protected function iterate()
    {
        try {
            $iterator = $this->getIterator();
            foreach ($iterator as $user) {
                $this->processInternal($user);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            //Yii::log($e->getMessage(), CLogger::LEVEL_ERROR, 'mail');
        }
    }

    /**
     * Действия, которые должны быть совершены перед рассылкой и "обходом" пользователей. Рассылка будет сделана только
     * в том случае, если данный момент возвращает истину
     *
     * @return bool
     */
    protected function beforeSend()
    {
        $lastDelivery = MailSendersHistory::model()->getLastDelivery($this->getDeliveryType());
        $this->lastDeliveryTimestamp = ($lastDelivery === null) ? null : $lastDelivery->timestamp;

        $newDelivery = new MailSendersHistory();
        $newDelivery->type = $this->type;
        $newDelivery->save();

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
            'pagination' => false,
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
                $criteria->join = 'LEFT OUTER JOIN auth__assignments aa ON aa.userid = t.id AND aa.itemname = :itemname';
                $criteria->params[':itemname'] = 'tester';
                $criteria->addCondition('aa.itemname IS NOT NULL');
                $criteria = $this->limitByPercent($criteria);
                break;
        }

        return $criteria;
    }

    protected function limitByPercent(CDbCriteria $criteria)
    {
        if ($this->percent != 100) {
            $count = User::model()->count();
            $offset = round($count * (100 - $this->percent) / 100);
            $last = User::model()->find(array(
                'order' => 'id DESC',
                'offset' => $offset,
            ));
            $criteria->addCondition('id < :lastId', 'OR');
            $criteria->params[':lastId'] = $last->id;
            $criteria->order = 'id ASC';
        }
        return $criteria;
    }
}

