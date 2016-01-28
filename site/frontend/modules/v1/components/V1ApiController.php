<?php

namespace site\frontend\modules\v1\components;

use site\frontend\modules\signup\components\UserIdentity;
use site\frontend\modules\v1\config\Filter;
use site\frontend\modules\v1\actions\IPostProcessable;
use site\frontend\modules\v1\actions\IViewIncrementable;
use site\frontend\modules\v1\actions\ReLoginAction;
use site\frontend\modules\v1\actions\LoginAction;
use site\frontend\modules\v1\actions\LogoutAction;
use site\frontend\modules\v1\actions\CheckTokenAction;
use site\frontend\modules\v1\helpers\ApiLog;

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
 * @property $action
 * @property $key
 * @property $isFromCache
 */
class V1ApiController extends \CController
{
    /**@todo: add required params check and get functional in there for every action*/
    #region Constants
    const ID = 'id';
    const WITH = 'expand';
    const ORDER = 'order';
    const LIMIT = 'per-page';
    const OFFSET = 'page';

    const CACHE_EXPIRE = 300;
    const CACHE_COLLECTION_EXPIRE = 600;
    const KEYS_COLLECTION = 'KeysCollection';
    #endregion

    #region Fields
    public $data = null;
    public $pushData = null;
    public $identity;

    protected $error = null;
    protected $errorCode = null;
    public $requestType;

    private $comet;

    private $action = null;

    private $key;
    private $isFromCache = false;

    public function setAction($action)
    {
        $this->action = $action;
    }
    #region Pagination Fields
    private $currentPage;
    private $hasNext = false;
    #endregion

    #endregion

    /**
     * Create response.
     */
    private function complete()
    {
        if ($this->error == null && $this->data) {
            header('Content-Type: application/json', true);
            header('X-Has-Next: ' . var_export($this->hasNext, true));
            header('X-Current-Page: ' . $this->currentPage);
            header('X-Request-Type: ' . \Yii::app()->request->requestType);
            header('X-From-Cache: ' . var_export($this->isFromCache, true));
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
     *
     * @param $action
     */
    protected function afterAction($action)
    {
        if ($this->error == null && !$this->isFromCache) {
            $this->toArray();

            if (/*$this->action != null && */$this->action instanceof IPostProcessable) {
                $this->action->postProcessing($this->data);
            }

            if ($this->requestType == 'Param') {
                \Yii::app()->cache->set($this->key, $this->data, self::CACHE_EXPIRE);
                $this->setModelCollectionCache();
            }
        }

        if ($this->checkRequestType('GET') && $this->action instanceof IViewIncrementable) {
            if ($this->action->viewsIncrement() && $this->isFromCache) {
                \Yii::app()->cache->delete($this->key);
            }
        }

        $this->complete();

        parent::afterAction($action);
    }

    protected function checkRequestType($type)
    {
        return \Yii::app()->request->requestType == $type;
    }

    protected function isImplements($interface)
    {
        //ApiLog::i(print_r(class_implements($this->action), true));
        return ($this->action != null && in_array($interface, class_implements(get_class($this->action))));
    }

    protected function beforeAction()
    {
        return true;
    }

    #region Action
    /**
     * Simple get action with models. Include pagination and relations.
     *
     * @param $model
     * @param $action
     * @param string $where
     */
    public function get($model, $action, $where = null)
    {
        

        $this->setCacheKey($model, $where);

        $cache = \Yii::app()->cache->get($this->key);

        $this->action = $action;

        if ($cache) {
            $this->data = $cache;
            $this->isFromCache = true;
            return;
        }

        if (\Yii::app()->request->getParam(self::ID, null)) {
            $this->data = $model->with($this->getWithParameters($model))->findByPk(\Yii::app()->request->getParam(self::ID));
        } else {
            $params = $this->getPaginationParams();

            if ($where) {
                $params['condition'] = $where;
            }

            if (!empty($model->findAll(array('limit' => 1, 'offset' => $params['offset'] + $params['limit'] + 1)))) {
                $this->hasNext = true;
            }

            if (\Yii::app()->request->getParam(self::ORDER, null)) {
                //t for order with expand, when yii construct query with uncertain fields
                $params['order'] = 't.' . \Yii::app()->request->getParam(self::ORDER);
            }

            $this->data = $model->with($this->getWithParameters($model))->findAll($params);
        }

        if ($this->data == null) {
            $this->setError("NotFound", 404);
        }
    }

    /**
     * Sets $key field.
     *
     * @param $model - for classname
     * @param $where - for query condition.
     */
    private function setCacheKey($model, $where = null)
    {
        //\Yii::app()->cache->flush();

        $key = array();

        $key['model'] = get_class($model);
        $key['id'] = \Yii::app()->request->getParam('id');
        $key['expand'] = $this->getWithParameters($model);
        if (count($key['expand']) > 0) {
            $key['expand_models'] = array();

            foreach($key['expand'] as $expand) {
                array_push($key['expand_models'], $model->relations()[$expand][1]);
            }
        }

        if (!\Yii::app()->request->getParam('id', null)) {
            $key['condition'] = $where;
            $key['pagination'] = $this->getPaginationParams();
            $key['order'] = \Yii::app()->request->getParam('order', null);
        }

        $this->key = json_encode($key);
    }

    /**
     * Modify model cache keys collection.
     * Collection uses in CacheDeleteBehavior cause yii can't get list of keys in cache.
     */
    private function setModelCollectionCache()
    {
        $collection = \Yii::app()->cache->get(self::KEYS_COLLECTION);

        if ($collection) {
            if (!in_array($this->key, $collection)) {
                array_push($collection, $this->key);
            }
        } else {
            $collection = array($this->key);
        }
        \Yii::app()->cache->set(self::KEYS_COLLECTION, $collection, self::CACHE_COLLECTION_EXPIRE);

        //\Yii::log(print_r($collection, true), 'info', 'api');
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
    private function countTotalPages($model, $params, $page, $min = 0, $max = 0)
    {
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
    protected function post($required, $action)
    {
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
    private function getComet()
    {
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
    protected function send($channel, $data, $type)
    {
        $this->getComet()->send($channel, $data, $type);
    }
    #endregion

    #region Auth
    public function auth()
    {
        if ($this->action instanceof ReLoginAction
            || $this->action instanceof LogoutAction
            || $this->action instanceof CheckTokenAction) {
            return true;
        }

        $required = array(
            'auth_email' => true,
            'auth_password' => true,
        );

        $socialRequired = array(
            'access_token' => true,
            'service' => true
        );

        $apiRequired = array(
            'access_token' => true,
        );

        if ($this->checkParams($required) /*&& $this->action instanceof LoginAction*/) {
            $params = $this->getParams($required);
            $this->identity = new UserIdentity($params['auth_email'], $params['auth_password']);
        } else if ($this->checkParams($socialRequired)) {
            $params = $this->getParams($socialRequired);

            $this->identity = new ApiSocialUserIdentity($params['access_token'],
                isset($params['service']) ? $params['service'] : null);
        } else if ($this->checkParams($apiRequired)) {
            $params = $this->getParams($apiRequired);

            $this->identity = new ApiUserIdentity($params['access_token']);
        } else {
            $this->setError("AuthParamsMissing", 401);
            return false;
        }

        if (!($this->identity->authenticate())) {
            /*if (isset($params['refresh_token']) && $this->identity instanceof ApiUserIdentity) {
                $this->identity->refresh($params['refresh_token']);

                $this->data = $this->identity->token;
                $this->complete();
                return;
            }*/

            $this->setError($this->identity->errorMessage, 401);
            return false;
        } else {
            ApiLog::i($this->identity->getId());
            \Yii::app()->user->login($this->identity);
            return true;
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
    private function getPaginationParams()
    {
        $size = isset($_GET[self::LIMIT]) ? \Yii::app()->request->getParam(self::LIMIT): 20;

        if ($size > 100) {
            $size = 100;
        } else if ($size <= 0) {
            $size = 20;
        }

        $this->currentPage = $page = isset($_GET[self::OFFSET]) ? \Yii::app()->request->getParam(self::OFFSET): 1;

        if ($this->currentPage <= 0) {
            $this->currentPage = 1;
        }

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
    public function getWithParameters($model)
    {
        if (isset($_GET[self::WITH])) {
            $temp = explode(",", \Yii::app()->request->getParam(self::WITH));

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
    private function toArray()
    {
        $data = array();
        /**@todo: запихнуть обработку одного элемента в отдельный метод*/
        if (is_array($this->data)) {
            //ApiLog::i('data is array');
            foreach ($this->data as $item) {
               // ApiLog::i('entering data foreach cycle');
                if (!($item instanceof \CActiveRecord || $item instanceof \EMongoDocument)) {
                    //ApiLog::i('item in data is not CActiveRecord');
                    return;
                }

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
            if (!($this->data instanceof \CActiveRecord || $this->data instanceof \EMongoDocument)) {
                return;
            }

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

    private function postProcessingWith(&$with)
    {
        if (is_array($with)) {
            foreach ($with as $key => $item) {
                $with[$key] = $item->getAttributes(Filter::getFilter($item->getAttributes(), get_class($item)));
            }
        } else {
            $with = $with->getAttributes(Filter::getFilter($with->getAttributes(), get_class($with)));
        }
    }

    private function setRelated($item, $out)
    {
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
    public function push($className, $type)
    {
        $this->send($className::getChannel($this->data), $this->pushData, $type);
    }

    /**
     * Checking request params.
     *
     * @param array $required -> array of required fields (key -> name, value -> strong or possible require)
     * @return bool -> true if all required fields sending, false if not.
     */
    public function checkParams($required)
    {
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
    public function getParams($required)
    {
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
    public function getFilteredParams($params, $filter, $isExcept)
    {
        $result = array();

        foreach ($params as $key => $value) {
            if (isset($filter[$key])) {
                if (!$isExcept) {
                    //$result['test'] = 'test';
                    $result[$key] = $value;
                }
            } else {
                if ($isExcept) {
                    //$result['test'] = 'test';
                    $result[$key] = $value;
                }
            }
        }

        return $result;
    }

    public function setError($message, $code)
    {
        $this->error = array('error' => $message);
        $this->errorCode = $code;
    }
    #endregion
}
