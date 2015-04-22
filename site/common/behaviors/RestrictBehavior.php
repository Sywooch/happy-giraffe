<?php

namespace site\common\behaviors;

/**
 * Поведение, запрещающие изменение указанных атрибутов модели,
 * спустя определённое время, после её создания/публикации.
 *
 * @author Кирилл
 */
class RestrictBehavior extends \CActiveRecordBehavior
{

    /**
     *
     * @var string[] Массив имён полей, требуещих ограничение на изменение, спустя определённое время 
     */
    public $fixAttributes = array();

    /**
     *
     * @var string Название атрибута, по которому будет считаться время. Атрибут должен хранить время в формате unix timestamp (секунды с эпохи UNIX)
     */
    public $dtimeField = 'dtimeUpdate';

    /**
     *
     * @var int Количество секунд, спустя которое, после создания записи, будет запрещено редактирование атрибутов модели
     */
    public $restrictTime = 604800; // 86400 * 7 Неделя
    /**
     *
     * @var mixed Один сценарий, или массив сценариев, для которых будет применяться ограничение.
     */
    public $onScenario = false;

    /**
     *
     * @var mixed Один сценарий, или массив сценариев, для которых не будет применяться ограничение
     */
    public $exceptScenario = false;
    protected $_fixedAttributes = array();

    public function afterFind($event)
    {
        foreach ($this->fixAttributes as $attribute) {
            $this->_fixedAttributes[$attribute] = $this->owner->$attribute;
        }
        parent::afterFind($event);
    }

    protected function resetValues()
    {
        foreach ($this->fixAttributes as $attribute) {
            if (isset($this->_fixedAttributes[$attribute])) {
                $this->owner->$attribute = $this->_fixedAttributes[$attribute];
            }
        }
    }

    public function beforeValidate($event)
    {
        $dtime = $this->owner->{$this->dtimeField};
        if ($dtime && $this->checkScenario($this->owner->scenario)) {
            if (time() - $dtime > $this->restrictTime) {
                $this->resetValues();
            }
        }
        parent::beforeValidate($event);
    }

    protected function checkScenario($scenario)
    {
        $success = true;
        if ($this->onScenario) {
            $success = in_array($scenario, (array) $this->onScenario);
        }
        if ($this->exceptScenario) {
            $success = !in_array($scenario, (array) $this->exceptScenario);
        }
        return $success;
    }

}
