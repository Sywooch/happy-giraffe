<?php

namespace site\frontend\components\api\models;

/**
 * Модель, общая для моделей, работающих через API
 *
 * @author Кирилл
 * 
 * @property \CCache $cache компонент для кеширования
 */
abstract class ApiModel extends \CModel
{

    /** @todo Впилить работу с составным первичным ключом */
    protected static $_models = array();
    private $_attributes = array();
    private $_new = false;
    public $api = false;
    public $expire = 3600;

    public function getCachedActions()
    {
        return array(
            'get',
            'list',
            'search',
        );
    }

    public function actionAttributes()
    {
        return array(
            'insert' => array_keys($this->attributes()),
            'update' => array_keys($this->attributes()),
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

    protected function setInternal($attributes)
    {
        foreach ($attributes as $name => $value)
        {
            if (property_exists($this, $name) || $this->canSetProperty($name))
                $this->$name = $value;
            else
                $this->_attributes[$name] = $value;
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

    public function save($runValidation = true)
    {
        if (!$runValidation || $this->validate($attributes))
            return $this->getIsNewRecord() ? $this->insert() : $this->update();
        else
            return false;
    }

    protected function insert()
    {
        if (!$this->getIsNewRecord())
            throw new \site\frontend\components\api\ApiException('Нельзя добавить не новую запись.');
        if ($this->beforeSave())
        {
            $this->trace(get_class($this) . '.insert()');
            $attributes = $this->actionAttributes();
            if (!isset($attributes['insert']) || !$attributes['insert'])
                throw new \site\frontend\components\api\ApiException('Настройками запрещено добавлять данную запись. Проверьте ' . get_class($this) . '::actionAttributes()');
            $request = array();
            foreach ($attributes['insert'] as $attribute)
                $request[$attribute] = $this->$attribute;

            $result = $this->request('create', $params);

            if ($result['success'])
            {
                if (isset($result['data']))
                    $this->setInternal($result['data']);
                $this->afterSave();
                $this->setIsNewRecord(false);
                $this->setScenario('update');
                return true;
            }
            else
            {
                /** @todo Обработать ошибки */
                return false;
            }
        }
        return false;
    }

    public function update()
    {
        if ($this->getIsNewRecord())
            throw new \site\frontend\components\api\ApiException('Нельзя обновить новую запись.');
        if ($this->beforeSave())
        {
            $this->trace(get_class($this) . '.update()');
            $attributes = $this->actionAttributes();
            if (!isset($attributes['insert']) || !$attributes['insert'])
                throw new \site\frontend\components\api\ApiException('Настройками запрещено добавлять данную запись. Проверьте ' . get_class($this) . '::actionAttributes()');
            $request = array();
            foreach ($attributes['insert'] as $attribute)
                $request[$attribute] = $this->$attribute;

            $result = $this->request('create', $params);

            if ($result['success'])
            {
                if (isset($result['data']))
                    $this->setInternal($result['data']);
                $this->afterSave();
                return true;
            }
            else
            {
                /** @todo Обработать ошибки */
                return false;
            }
            return true;
        }
        else
            return false;
    }

    public function getIsNewRecord()
    {
        return $this->_new;
    }

    public function setIsNewRecord($value)
    {
        $this->_new = $value;
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
                    /** @todo пробрасывать ошибки в модель */
                    $models[] = $this->populateRecord($response['data']);
                }
            }
            return $models;
        }
        else
        {
            $model = null;
            /** @todo пробрасывать ошибки в модель */
            if (isset($result['data']) && $result['success'])
                $model = $this->populateRecord($result['data']);
            return $model;
        }
    }

    public function request($action, $params)
    {
        if ($this->isCachedAction($action) && is_array($params))
        {
            $result = null;
            if (isset($params['pack']))
            {
                $newPack = array();
                $result = $this->cacheGet($action, $params['pack'], true);
                foreach ($result as $i => $data)
                {
                    if (!$data)
                        $newPack[] = $params['pack'][$i];
                }
                /** @todo Дописать кеширование!!! */
            }
            else
            {
                $this->trace('try cache ' . $action . ' (' . var_export($params, true) . ')');
                $result = $this->cacheGet($action, $params);
                if (!$result)
                {
                    $this->trace('try api');
                    $result = \Yii::app()->api->request($this->api, $action, $params);
                    $this->cacheSet($action, $params, $result);
                }
            }

            return $result;
        }
        return \Yii::app()->api->request($this->api, $action, $params);
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
            $record->setInternal($attributes);
            $record->attachBehaviors($record->behaviors());
            if ($callAfterFind)
                $record->afterFind();
            return $record;
        }
        else
            return null;
    }

    /* cache */

    protected function caheKey($action, $args)
    {
        return $this->api . '|' . $action . '|' . implode('|', array_keys($args)) . implode('|', $args);
    }

    protected function cacheGet($action, $args, $pack = false)
    {
        if (!$pack)
            $args = array($args);
        $kyes = array();
        foreach ($args as $i => $a)
            $keys[] = $this->caheKey($action, $a);

        $result = array_values($this->cache->mget($keys));
        if (!$pack)
            $result = $result[0];
        return $result;
    }

    protected function cacheSet($action, $args, $result)
    {
        $this->cache->set($this->caheKey($action, $args), $result, $this->expire);
    }

    /* events */

    /**
     * This method is invoked before saving a record (after validation, if any).
     * The default implementation raises the {@link onBeforeSave} event.
     * You may override this method to do any preparation work for record saving.
     * Use {@link isNewRecord} to determine whether the saving is
     * for inserting or updating record.
     * Make sure you call the parent implementation so that the event is raised properly.
     * @return boolean whether the saving should be executed. Defaults to true.
     */
    protected function beforeSave()
    {
        if ($this->hasEventHandler('onBeforeSave'))
        {
            $event = new \CModelEvent($this);
            $this->onBeforeSave($event);
            return $event->isValid;
        }
        else
            return true;
    }

    /**
     * This event is raised before the record is saved.
     * By setting {@link CModelEvent::isValid} to be false, the normal {@link save()} process will be stopped.
     * @param CModelEvent $event the event parameter
     */
    public function onBeforeSave($event)
    {
        $this->raiseEvent('onBeforeSave', $event);
    }

    /**
     * This method is invoked after saving a record successfully.
     * The default implementation raises the {@link onAfterSave} event.
     * You may override this method to do postprocessing after record saving.
     * Make sure you call the parent implementation so that the event is raised properly.
     */
    protected function afterSave()
    {
        if ($this->hasEventHandler('onAfterSave'))
            $this->onAfterSave(new \CEvent($this));
    }

    /**
     * This event is raised after the record is saved.
     * @param CEvent $event the event parameter
     */
    public function onAfterSave($event)
    {
        $this->raiseEvent('onAfterSave', $event);
    }

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
