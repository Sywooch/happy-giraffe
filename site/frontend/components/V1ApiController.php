<?php

/**
 * @property string $data
 * @property bool $success
 * @property array $errors
 * @property string $requestType
 * @property CometModel $comet
 * @property int $currentPage
 * @property bool $hasNext
 */
class V1ApiController extends \CController
{
    #region Fields
    protected $data = null;
    protected $success = false;

    protected $errors = null;
    protected $requestType;

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
        if ($this->success && $this->data) {
            header('Content-Type: application/json', true);
            header('X-Has-Next: ' . var_export($this->hasNext, true));
            header('X-Current-Page: ' . $this->currentPage);
            header('X-Request-Type: ' . \Yii::app()->request->requestType);
            echo \CJSON::encode($this->data);
        } else {

        }
    }

    /**
     * Checks request type and call response.
     */
    protected function afterAction($action) {
        if ($this->errors == null) {
            $this->success = true;
            if (\Yii::app()->request->requestType == 'GET') {
                $this->toArray();
                $this->complete();
            } else {
                $this->complete();
            }
        } else {

        }

        parent::afterAction($action);
    }

    protected function beforeAction() {
        /* @todo: authentication check */
        return true;
    }

    #region Action
    /**
     * Simple get action with models. Include pagination and relations.
     */
    protected function get($model) {
        if (isset($_GET['id'])){
            $this->data = $model->with($this->getWithParameters())->findByPk(\Yii::app()->request->getParam('id'));
        }
        else {
            $params = $this->getPaginationParams();

            if (!empty($model->findAll(array('limit' => 1, 'offset' => $params['offset'] + $params['limit'] + 1)))) {
                $this->hasNext = true;
            }

            if (isset($_GET['order'])){
                $params['order'] = \Yii::app()->request->getParam('order');
            }

            $this->data = $model->with($this->getWithParameters())->findAll($params);
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
     */
    protected function post($required, $action) {
        if ($this->checkParams($required)) {
            try {
                $action($this, $required);
            } catch (Exception $e) {
                $this->data = $e->getMessage();
            }
        } else {
            $this->data = "Parameters missing";
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
     * @param type $type message type (constants from comet model)
     */
    protected function send($channel, $data, $type) {
        $this->getComet()->send($channel, $data, $type);
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
     * @return array of relations parameters.
     */
    private function getWithParameters(){
        if (isset($_GET['with'])){
            return explode(",", \Yii::app()->request->getParam('with'));
        } else {
            return null;
        }
    }

    /**
     * Convert models to array. This is necessary to json encode with relations.
     */
    private function toArray(){
        $data = array();
        if (is_array($this->data)){
            foreach ($this->data as $item) {
                $temp = $item->getAttributes();
                if ($this->getWithParameters() != null) {
                    foreach ($this->getWithParameters() as $with) {
                        $temp[$with] = $item->getRelated($with);
                    }
                }

                $data[] = $temp;
            }
        } else {
            $temp = $this->data->getAttributes();
            if ($this->getWithParameters() != null) {
                foreach ($this->getWithParameters() as $with) {
                    $temp[$with] = $this->data->getRelated($with);
                }
            }

            $data[] = $temp;
        }

        $this->data = $data;
    }

    private function setRelated($item, $out){
        foreach ($this->getWithParameters() as $with) {
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
    protected function push($className, $type) {
        $this->send($className::getChannel($this->data), $this->data, $type);
    }

    /**
     * Checking request params.
     *
     * @param array $required -> array of required fields (key -> name, value -> strong or possible require)
     * @return bool -> true if all required fields sending, false if not.
     */
    protected function checkParams($required) {
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
    protected function getParams($required) {
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
    protected function getFilteredParams($params, $filter, $isExcept) {
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
    #endregion
}