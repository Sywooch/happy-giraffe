<?php

namespace site\frontend\components\api;

/**
 * Реализация действия для упрощения работы с пакетной обработкой
 * https://happygiraffe.atlassian.net/wiki/display/S2/API#API-%D0%9F%D0%B0%D0%BA%D0%B5%D1%82%D0%BD%D0%B0%D1%8F%D0%BE%D0%B1%D1%80%D0%B0%D0%B1%D0%BE%D1%82%D0%BA%D0%B0
 *
 * @author Кирилл
 * @property \site\frontend\components\api\ApiController $controller
 * @property-read array $post Данные, отправленные в запросе
 * @property-read array $commonParams Данные, отправленные в запросе и общие для вызовов процедуры
 * @property-read bool $isPack Пакетная обратока
 */
class PackAction extends \CAction
{

    public $function = false;
    public $result = array();
    protected $_post = null;
    protected $_commonParams = null;

    public function run()
    {
        $methodName = $this->function ? $this->function : 'pack' . $this->id;
        $method = new \ReflectionMethod($this->controller, $methodName);
        $numberOfParameters = $method->getNumberOfParameters();
        if ($this->isPack)
        {
            for ($i = 0; $i < $this->packCount; $i++)
            {
                try
                {
                    $this->process($methodName, $method, $numberOfParameters, $this->getParams($i));
                    $this->result[$i] = $this->controller->result;
                    $this->controller->clearPack();
                }
                catch (\Exception $e)
                {
                    $this->result[$i] = array(
                        'success' => false,
                        'errorCode' => $e->getCode(),
                        'errorMessage' => $e->getMessage(),
                    );
                }
            }
            $this->controller->success = true;
            $this->controller->isPack = true;
            $this->controller->data = $this->result;
        }
        else
        {
            $this->process($methodName, $method, $numberOfParameters, $this->getParams());
        }
    }

    public function process($methodName, $method, $numberOfParameters, $params)
    {
        if ($numberOfParameters > 0)
            return $this->runWithParamsInternal($this->controller, $method, $params);
        else
            $this->controller->$methodName();
    }

    /**
     * 
     * @param int $i Номер вызова
     * @return array Именованный массив из пар параметр-значение, для одного вызова процедуры
     */
    public function getParams($i = false)
    {
        if ($this->isPack)
        {
            return \CMap::mergeArray($this->commonParams, $this->post['pack'][$i]);
        }
        else
        {
            return $this->post;
        }
    }

    public function getIsPack()
    {
        return isset($this->post['pack']);
    }

    public function getPackCount()
    {
        return $this->isPack ? count($this->post['pack']) : 0;
    }

    public function getPost()
    {
        if (is_null($this->_post))
            $this->_post = $_POST;

        return $this->_post;
    }

    public function getCommonParams()
    {
        if (is_null($this->_commonParams))
        {
            $this->_commonParams = $this->post;
            if (isset($this->_commonParams['pack']))
                unset($this->_commonParams['pack']);
        }

        return $this->_commonParams;
    }

}

?>
