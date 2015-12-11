<?php

namespace site\frontend\modules\v1\components;

use site\frontend\modules\signup\components\UserIdentity;
use site\frontend\modules\v1\config\Filter;

/**
 * @property string $data
 * @property bool $success
 * @property array $error
 * @property string $requestType
 * @property CometModel $comet
 * @property int $currentPage
 * @property bool $hasNext
 * @property UserIdentity $identity
 * @property int $errorCode
 * @property $pushData
 */
class V1ApiController extends \CController
{
    #region Fields
    public $data = null;
    public $pushData = null;
    public $identity;

    protected $error = null;
    protected $errorCode = null;
    public $requestType;

    private $comet;

    #region Pagination Fields
    private $currentPage;
    private $hasNext = false;
    #endregion
    #endregion

    /**
     * Create response.
     */
    private function complete() {
        if ($this->error == null && $this->data) {
            header('Content-Type: application/json', true);
            header('X-Has-Next: ' . var_export($this->hasNext, true));
            header('X-Current-Page: ' . $this->currentPage);
            header('X-Request-Type: ' . \Yii::app()->request->requestType);
            echo \CJSON::encode($this->data);
        } else {
            http_response_code($this->errorCode);
            header('Content-Type: application/json', true);
            header('X-Request-Type: ' . \Yii::app()->request->requestType);
            echo \CJSON::encode($this->error);
        }
    }

    /**
     * Checks request type and call response.
     */
    protected function afterAction($action) {
        if ($this->error == null) {
            $this->toArray();
            $this->complete();
        } else {
            $this->complete();
        }

        parent::afterAction($action);
    }

    protected function beforeAction() {
        return true;
    }

    #region Action
    /**
     * Simple get action with models. Include pagination and relations.
     *
     * @param $model
     */
    public function get($model) {
        if (isset($_GET['id'])) {
            $this->data = $model->with($this->getWithParameters($model))->findByPk(\Yii::app()->request->getParam('id'));
            if ($this->data == null) {
                $this->setError("NotFound", 404);
            }
        } else {
            $params = $this->getPaginationParams();

            if (!empty($model->findAll(array('limit' => 1, 'offset' => $params['offset'] + $params['limit'] + 1)))) {
                $this->hasNext = true;
            }

            if (isset($_GET['order'])) {
                $params['order'] = \Yii::app()->request->getParam('order');
            }

            $this->data = $model->with($this->getWithParameters($model))->findAll($params);
        }
    }

    /**
     * Don't use now.
     *
     * @param string $model - model class name.
     * @param array $params - params list.
     * @param int $page - current page.
     * @param int $min - left border
     * @param int $max - right border
     * @return int page number
     */
    private function countTotalPages($model, $params, $page, $min = 0, $max = 0) {
        if (!empty($model->findAll(array('limit' => 1, 'offset' => $params['limit'] * ($page - 1))))) {
            if (empty($model->findAll(array('limit' => 1, 'offset' => $params['limit'] * ($page))))) {
                return $page;
            }
            $min = $page;
            $page = $max == 0 ? ceil($page * 1.5) : ceil($page + (($max - $page) / 2)) ;
        } else {
            $max = $page;
            $page = $min == 0 ?  ceil($page / 2) : ceil(($page - $min) * 1.5) ;
        }
        return $this->countTotalPages($model, $params, $page, $min, $max);
    }

    /**
     * Here will be simple post action.
     *
     * @param $required
     * @param $action
     */
    protected function post($required, $action) {
        if ($this->checkParams($required)) {
            try {
                $action($this, $required);
            } catch (Exception $e) {
                $this->data = $e->getMessage();
            }
        } else {
            $this->setError("ParamsMissing", 400);
        }
    }
    #endregion

    #region Comet
    /**
     * Get comet instance.
     *
     * @return object $comet
     */
    private function getComet() {
        if (is_null($this->comet)) {
            $this->comet = new \CometModel();
        }

        return $this->comet;
    }

    /**
     * Send message using comet.
     *
     * @param string $channel channel id.
     * @param array $data message
     * @param int $type message type (constants from comet model)
     */
    protected function send($channel, $data, $type) {
        $this->getComet()->send($channel, $data, $type);
    }
    #endregion

    #region Auth
    public function auth() {
        $required = array(
            'auth_email' => true,
            'auth_password' => true,
        );

        if ($this->checkParams($required)) {
            $params = $this->getParams($required);
            $this->identity = new UserIdentity($params['auth_email'], $params['auth_password']);

            if (!($this->identity->authenticate())) {
                $this->setError($this->identity->errorMessage, 401);
                return false;
            } else {
                return true;
            }
        } else {
            $this->setError("AuthParamsMissing", 401);
            return false;
        }
    }
    #endregion

    #region Helpers
    /**
     * Construct pagination params from request.
     *
     * @return array of pagination params.
     * @limit -> query limit
     * @offset -> query offset
     */
    private function getPaginationParams() {
        $size = isset($_GET['size']) ? \Yii::app()->request->getParam('size'): 20;
        $this->currentPage = $page = isset($_GET['page']) ? \Yii::app()->request->getParam('page'): 1;

        return array(
            'limit' => $size,
            'offset' => ($page - 1) * $size
        );
    }

    /**
     * Construct with parameter.
     *
     * @param $model
     * @return array of relations parameters.
     */
    private function getWithParameters($model){
        if (isset($_GET['with'])){
            $temp = explode(",", \Yii::app()->request->getParam('with'));

            foreach ($temp as $key => $value) {
                if (!isset($model->relations()[$value])) {
                    unset($temp[$key]);
                }
            }

            $temp = Filter::filterWithParameters($temp, get_class($model));
            return $temp;
        } else {
            return null;
        }
    }

    /**
     * Convert models to array. This is necessary to json encode with relations.
     */
    private function toArray() {
        $data = array();
        if (is_array($this->data)) {
            foreach ($this->data as $item) {
                $temp = $item->getAttributes(Filter::getFilter($item->getAttributes(), get_class($item)));
                //$temp['filter_array'] = Filter::getFilter($item->getAttributes(), get_class($item));
                if ($this->getWithParameters($item) != null) {
                    foreach ($this->getWithParameters($item) as $with) {
                        $temp[$with] = $item->getRelated($with);
                        if (is_object($temp[$with])) {
                            $this->postProcessingWith($temp[$with]);
                        }
                    }
                }

                $data[] = $temp;
            }
        } else {
            $temp = $this->data->getAttributes(Filter::getFilter($this->data->getAttributes(), get_class($this->data)));
            if ($this->getWithParameters($this->data) != null) {
                foreach ($this->getWithParameters($this->data) as $with) {
                    $temp[$with] = $this->data->getRelated($with);
                    if (is_object($temp[$with])) {
                        $this->postProcessingWith($temp[$with]);
                    }
                }
            }

            $data[] = $temp;
        }

        $this->data = $data;
    }

    private function postProcessingWith(&$with) {
        if (is_array($with)) {
            foreach ($with as $key => $item) {
                $with[$key] = $item->getAttributes(Filter::getFilter($item->getAttributes(), get_class($item)));
            }
        } else {
            $with = $with->getAttributes(Filter::getFilter($with->getAttributes(), get_class($with)));
        }
    }

    private function setRelated($item, $out){
        foreach ($this->getWithParameters($item) as $with) {
            $out[$with] = $item->getRelated($with);
        }
    }

    /**
     * Including legacy plexor sending.
     * Including nginx stream sending. (not now)
     *
     * @param string $className -> name of model
     * @param int $type -> plexor type.
     */
    public function push($className, $type) {
        $this->send($className::getChannel($this->data), $this->pushData, $type);
    }

    /**
     * Checking request params.
     *
     * @param array $required -> array of required fields (key -> name, value -> strong or possible require)
     * @return bool -> true if all required fields sending, false if not.
     */
    public function checkParams($required) {
        $method = 'get' . $this->requestType;
        foreach ($required as $param => $status) {
            if (\Yii::app()->request->$method($param, null) == null) {
                if ($status == true) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Creating array with sending request params.
     *
     * @param array $required -> array of required fields (key -> name, value -> strong or possible require (not used))
     * @return array -> array with all sending fields.
     */
    public function getParams($required) {
        $method = 'get' . $this->requestType;
        $params = array();
        foreach ($required as $param => $status) {
            $params[$param] = \Yii::app()->request->$method($param, null);
        }

        return $params;
    }

    /**
     * Construct params array by filter.
     *
     * @param array $params -> array of all params.
     * @param array $filter -> array of filter params.
     * @param bool $isExcept -> if true result is params without filter, if false result is filter params.
     *
     * @return array $result -> filtered params.
     */
    public function getFilteredParams($params, $filter, $isExcept) {
        $result = array();

        foreach ($params as $key => $value) {
            if (isset($filter[$key])) {
                if (!$isExcept) {
                    $result['test'] = 'test';
                    $result[$key] = $value;
                }
            } else {
                if ($isExcept) {
                    $result['test'] = 'test';
                    $result[$key] = $value;
                }
            }
        }

        return $result;
    }

    public function setError($message, $code) {
        $this->error = array('error' => $message);
        $this->errorCode = $code;
    }
    #endregion
}