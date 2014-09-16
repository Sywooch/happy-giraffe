<?php

namespace site\frontend\components\api;

/**
 * Description of ApiController
 *
 * @author Кирилл
 * 
 * @property-read \CometModel $comet Экземпляр CometModel для работы с comet-сервером
 */
class ApiController extends \CController
{

    /**
     * @var array Объект, который будет возвращаться в ответ на запрос 
     */
    public $result = false;
    protected $_cometModel = null;

    public function filters()
    {
        return array(
            /** @todo Тут будет проверка токена для приложений */
            // Всё API работает только через post-запросы
            'postOnly',
        );
    }

    public function getComet()
    {
        if (is_null($this->_cometModel))
        {
            $this->_cometModel = new \CometModel();
        }

        return $this->_cometModel;
    }

    public function afterAction($action)
    {
        if ($this->result)
            echo \CJSON::encode($this->result);
        return parent::afterAction($action);
    }

    /**
     * Метод, отсылающий сообщение через comet-сервер
     * 
     * @param string $channel Id канала, или id пользователя, при отправке в его публичный канал
     * @param array $data Данные для отправки
     * @param type $type Тип сообщения, смотри константы из CometModel
     */
    public function send($channel, $data, $type)
    {
        $comet->send($channel, $data, $type);
    }

}

?>
