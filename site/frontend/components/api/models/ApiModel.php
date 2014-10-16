<?php

namespace site\frontend\components\api\models;

/**
 * Модель, общая для моделей, работающих через API
 *
 * @author Кирилл
 */
abstract class ApiModel extends \CModel
{

    protected static $_models = array();
    private $_attributes = array();
    public $api = false;

    public function getCachedActions()
    {
        return array(
            'get',
            'list',
            'search',
        );
    }

    public function isCachedAction($action)
    {
        return array_search($action, $this->getCachedActions()) !== false;
    }

    public function __construct()
    {
        if (!\Yii::app()->api)
            throw new Exception('Компонент api должен быть сконфигурирован');
    }

    public function init()
    {
        
    }

    public function trace($msg)
    {
        \Yii::trace($msg, __CLASS__);
    }

    public function __get($name)
    {
        if (isset($this->_attributes[$name]))
            return $this->_attributes[$name];
        else
        {
            $attributes = $this->attributeNames();
            if (array_search($name, $attributes) !== false)
                return null;
            return parent::__get($name);
        }
    }

    public static function model($className = __CLASS__)
    {
        if (isset(self::$_models[$className]))
            return self::$_models[$className];
        else
        {
            $model = self::$_models[$className] = new $className(null);
            $model->attachBehaviors($model->behaviors());
            return $model;
        }
    }

    public function findByPk($id)
    {
        self::trace('findByPk(' . $id . ')');
        return $this->query('get', array('id' => $id));
    }

    public function query($action, $params)
    {
        $this->beforeFind();
        $result = $this->extract($this->request($action, $params));
        if (!$result['success'])
            throw new \site\frontend\components\api\ApiException($result['errorMessage'], $result['errorCode'] ? : '');
        if (isset($result['isPack']))
        {
            $models = array();
            foreach ($result['data'] as $response)
            {
                if (isset($response['data']) && $response['success'])
                {
                    $models[] = $this->populateRecord($response['data']);
                }
            }
            return $models;
        }
        else
        {
            $model = null;
            if (isset($result['data']) && $result['success'])
                $model = $this->populateRecord($result['data']);
            return $model;
        }
    }

    public function request($action, $params)
    {
        if ($this->isCachedAction($action) && is_array($params))
        {
            if (isset($params['pack']))
            {
                
            }
            else
            {
                
            }
        }
        return \Yii::app()->api->request($this->api, $action, $params);
    }

    public function tryCache($key)
    {
        return $this->cache->get($key);
    }

    public function getCache()
    {
        return \Yii::app()->api->cache;
    }

    public function extract($response)
    {
        return \CJSON::decode($response);
    }

    protected function instantiate($attributes)
    {
        $class = get_class($this);
        $model = new $class(null);
        return $model;
    }

    protected function populateRecord($attributes, $callAfterFind = true)
    {
        if ($attributes !== false)
        {
            $record = $this->instantiate($attributes);
            $record->init();
            foreach ($attributes as $name => $value)
                if (property_exists($this, $name))
                    $record->$name = $value;
                else
                    $record->_attributes[$name] = $value;
            $record->attachBehaviors($record->behaviors());
            if ($callAfterFind)
                $record->afterFind();
            return $record;
        }
        else
            return null;
    }

    // Не используется
    /* public function populateRecords($data, $callAfterFind = true, $index = null)
      {
      $records = array();
      foreach ($data as $attributes)
      {
      if (($record = $this->populateRecord($attributes, $callAfterFind)) !== null)
      {
      if ($index === null)
      $records[] = $record;
      else
      $records[$record->$index] = $record;
      }
      }
      return $records;
      } */

    protected function caheKey($action, $args)
    {
        return $this->api . '|' . $action . '|' . implode('|', $args);
    }

    /* events */

    /**
     * This method is invoked before an AR finder executes a find call.
     * The find calls include {@link find}, {@link findAll}, {@link findByPk},
     * {@link findAllByPk}, {@link findByAttributes}, {@link findAllByAttributes},
     * {@link findBySql} and {@link findAllBySql}.
     * The default implementation raises the {@link onBeforeFind} event.
     * If you override this method, make sure you call the parent implementation
     * so that the event is raised properly.
     * For details on modifying query criteria see {@link onBeforeFind} event.
     */
    protected function beforeFind()
    {
        if ($this->hasEventHandler('onBeforeFind'))
        {
            $event = new \CModelEvent($this);
            $this->onBeforeFind($event);
        }
    }

    /**
     * This method is invoked after each record is instantiated by a find method.
     * The default implementation raises the {@link onAfterFind} event.
     * You may override this method to do postprocessing after each newly found record is instantiated.
     * Make sure you call the parent implementation so that the event is raised properly.
     */
    protected function afterFind()
    {
        if ($this->hasEventHandler('onAfterFind'))
            $this->onAfterFind(new \CEvent($this));
    }

    /**
     * This event is raised before an AR finder performs a find call.
     * This can be either a call to CActiveRecords find methods or a find call
     * when model is loaded in relational context via lazy or eager loading.
     * If you want to access or modify the query criteria used for the
     * find call, you can use {@link getDbCriteria()} to customize it based on your needs.
     * When modifying criteria in beforeFind you have to make sure you are using the right
     * table alias which is different on normal find and relational call.
     * You can use {@link getTableAlias()} to get the alias used for the upcoming find call.
     * Please note that modification of criteria is fully supported as of version 1.1.13.
     * Earlier versions had some problems with relational context and applying changes correctly.
     * @param CModelEvent $event the event parameter
     * @see beforeFind
     */
    public function onBeforeFind($event)
    {
        $this->raiseEvent('onBeforeFind', $event);
    }

    /**
     * This event is raised after the record is instantiated by a find method.
     * @param CEvent $event the event parameter
     */
    public function onAfterFind($event)
    {
        $this->raiseEvent('onAfterFind', $event);
    }

}

?>
