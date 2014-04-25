<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 24/04/14
 * Time: 15:01
 * To change this template use File | Settings | File Templates.
 */

abstract class MailMassSender extends MailSender
{
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
        } catch (CException $e) {
            Yii::log($e->getMessage(), CLogger::LEVEL_ERROR, 'mail');
        }
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
            $this->process($user);
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
}