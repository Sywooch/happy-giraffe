<?php

namespace site\frontend\components\api;

/**
 * Description of ApiController
 *
 * @author Кирилл
 * 
 * @property-read \CometModel $comet Экземпляр CometModel для работы с comet-сервером
 * @property-read array $result Данные, возвращаемые в ответе на запрос
 */
class ApiController extends \CController
{

    /**
     * @var array Объект, который будет возвращаться в ответ на запрос 
     */
    public $data = null;

    /**
     * @var bool true - запрос обработан успешно, false - возникла ошибка
     */
    public $success = false;

    /**
     * @var int Код ошибки
     */
    public $errorCode = null;

    /**
     * @var string Текст ошибки
     */
    public $errorMessage = null;

    /**
     *
     * @var bool true - используется пакетная обработка, иначе - false 
     */
    public $isPack = false;

    /**
     * @var CometModel 
     */
    protected $_cometModel = null;

    /**
     * Метод, устанавливающий стандартные значения ответа, перед использованием пакетной обработки
     */
    public function clearPack()
    {
        $this->data = null;
        $this->success = false;
        $this->errorCode = null;
        $this->errorMessage = null;
        $this->isPack = false;
    }

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

    public function getResult()
    {
        $result = array('success' => (bool) $this->success);
        if (!is_null($this->errorCode))
            $result['errorCode'] = $this->errorCode;
        if (!is_null($this->errorMessage))
            $result['errorMessage'] = $this->errorMessage;
        if ($this->isPack)
            $result['isPack'] = true;
        if (!is_null($this->data))
            $result['data'] = $this->data;

        return $result;
    }

    // Вывод результата в конце действия
    public function afterAction($action)
    {
        $this->printResult();

        return parent::afterAction($action);
    }

    // Метод, отвечающий за вывод результата
    public function printResult()
    {
        echo \HJSON::encode($this->result);
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

    // Переписываем ошибку для отсутствующего метода
    public function missingAction($actionID)
    {
        throw new \CHttpException(404, 'Отсутствует метод ' . $actionID);
    }

    // Вешаем обработку ошибок
    public function run($action)
    {
        header('Content-Type: application/json');
//        \Yii::app()->attachEventHandler('onError', array($this, 'onError'));
//        \Yii::app()->attachEventHandler('onException', array($this, 'onError'));
        parent::run($action);
    }

    // Обработчик ошибок
    public function onError(\CEvent $event)
    {
        $event->handled = true;
        if ($event instanceof \CExceptionEvent)
            $exception = $event->exception;
        else // CErrorEvent
            $exception = $event;

        $this->success = false;
        $this->errorCode = method_exists($exception, 'getCode') ? $exception->getCode() : $exception->code;
        $this->errorMessage = method_exists($exception, 'getMessage') ? $exception->getMessage() : $exception->message;
        $this->data = null;

        $this->printResult();
    }

    public function getActionParams()
    {
        return \CJSON::decode(@\file_get_contents('php://input'));
    }

}

?>
