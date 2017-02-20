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

    public $errorTrace = [];

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
     *
     * @var array Массив запомненных моделей
     */
    protected $_models = [];

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
        return [
            /** @todo Тут будет проверка токена для приложений */
            /** @todo Сделать проверку на дос (ограничить количество запросов с одного ip/браузера) */
            /** @todo Сделать проверку referrer/ip для определения наших запросов */
            /** @todo Сделать проверку заголовка content-type на application/json */
            /** @todo Придумать защиту от скачивания */
            // Всё API работает только через post-запросы
            'postOnly',
        ];
    }

    public function getComet()
    {
        if (is_null($this->_cometModel)) {
            $this->_cometModel = new \CometModel();
        }

        return $this->_cometModel;
    }

    public function getResult()
    {
        $result = ['success' => (bool) $this->success];
        if (!is_null($this->errorCode))
            $result['errorCode'] = $this->errorCode;
        if (!is_null($this->errorMessage))
            $result['errorMessage'] = $this->errorMessage;
        if ($this->isPack)
            $result['isPack'] = true;
        if (!is_null($this->data))
            $result['data'] = $this->data;
        if (!empty($this->errorTrace)) {
            $result['errorTrace'] = $this->errorTrace;
        }

        return $result;
    }

    protected function beforeAction($action)
    {
        foreach (\Yii::app()->log->routes as $route) {
            if ($route instanceof \CProfileLogRoute) {
                $route->enabled = false;
            }
        }

        return true;
    }

    // Вывод результата в конце действия
    public function afterAction($action)
    {
        $this->printResult();

        parent::afterAction($action);
    }

    // Метод, отвечающий за вывод результата
    public function printResult()
    {
        header('Content-Type: application/json', true);
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
        $this->comet->send($channel, $data, $type);
    }

    // Переписываем ошибку для отсутствующего метода
    public function missingAction($actionID)
    {
        throw new \CHttpException(404, 'Отсутствует метод ' . $actionID);
    }

    // Вешаем обработку ошибок
    public function run($action)
    {
        \Yii::app()->attachEventHandler('onError', [$this, 'onError']);
        \Yii::app()->attachEventHandler('onException', [$this, 'onError']);

        parent::run($action);
    }

    // Обработчик ошибок
    public function onError(\CEvent $event)
    {
        header('Content-Type: application/json', true);

        $event->handled = true;
        /** @var \CErrorEvent|\CException $exception */
        if ($event instanceof \CExceptionEvent)
            $exception = $event->exception;
        else // CErrorEvent
            $exception = $event;

        $code = method_exists($exception, 'getCode') ? $exception->getCode() : $exception->code;
        $message = method_exists($exception, 'getMessage') ? $exception->getMessage() : $exception->message;

        $this->success = false;
        $this->errorCode = $code;
        $this->errorMessage = $message;
        $this->data = null;
        $this->errorTrace = method_exists($exception, 'getTrace') ? $exception->getTrace() : [];

        http_response_code(isset($exception->statusCode) ? $exception->statusCode : 500);

        if (YII_DEBUG) {
            $this->printResult();
        }
    }

    public function getActionParams()
    {
        return \CJSON::decode(@\file_get_contents('php://input'));
    }

    public function getModel($class, $id, $checkAccess = false, $resetScope = false)
    {
        if (!isset($this->_models[$class][$id][(int) $resetScope])) {
            if ($resetScope)
                $this->_models[$class][$id][(int) $resetScope] = $class::model()->resetScope(true)->findByPk($id);
            else
                $this->_models[$class][$id][(int) $resetScope] = $class::model()->findByPk($id);
        }

        if ($checkAccess && !$this->_models[$class][$id][(int) $resetScope])
            throw new \CHttpException(404, 'Модель не найдена');
        if ($checkAccess !== true && $checkAccess !== false && !\Yii::app()->user->checkAccess($checkAccess, ['entity' => $this->_models[$class][$id][(int) $resetScope]]))
            throw new \CHttpException(403, 'Недостаточно прав');


        return $this->_models[$class][$id][(int) $resetScope];
    }

}

?>
