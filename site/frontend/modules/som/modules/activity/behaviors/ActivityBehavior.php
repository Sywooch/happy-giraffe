<?php

namespace site\frontend\modules\som\modules\activity\behaviors;

use site\frontend\modules\som\modules\activity\models\api\Activity;

/**
 * Description of ActivityBehavior
 *
 * @author Кирилл
 */
abstract class ActivityBehavior extends \CActiveRecordBehavior
{

    public $isRemoved = null;

    public function attach($owner)
    {
        parent::attach($owner);
        $this->isRemoved = $this->owner->isNewRecord ? null : $this->getIsRemoved();
    }

    public function afterSave($event)
    {
        if ($this->isRemoved === $this->getIsRemoved()) {
            // Ничего не изменилось
            return;
        }

        if ($this->getIsRemoved() == 0) {
            $this->addActivity();
        }

        if ($this->getIsRemoved() == 1) {
            $this->delActivity();
        }
    }

    /**
     * Добавление активности
     */
    public function addActivity()
    {
        try {
            $activity = $this->getActivityModel();
            $activity->hash = $this->getActivityId();
            $activity->save();
        } catch (Exception $ex) {
            
        }
    }

    /**
     * Удаление активности
     */
    public function delActivity()
    {
        try {
            Activity::model()->request('removeByHash', array('hash' => $this->getActivityId()));
        } catch (\Exception $ex) {
            
        }
    }

    /**
     * Восстановление активности
     * 
     * Сама активность не переписывается. Только создаётся/удаляется, если надо.
     * Не рекомендуется использовать этот метод вне консоли, т.к. может выполняться
     * достаточно долго.
     */
    public function renewActivity()
    {
        $activity = false;
        try {
            // Пробуем получить модель активности
            $activity = Activity::model()->query('hash', array('hash' => $this->getActivityId()));
        } catch (\Exception $ex) {
            $activity = false;
        }
        if ($activity && $this->getIsRemoved()) {
            // активность есть, но контент удалён
            // дропаем активность
            $this->delActivity();
        } elseif (!$activity && !$this->getIsRemoved()) {
            // нет активности, контент не удалён
            // создаём активность
            $this->addActivity();
        }
    }

    /**
     * Метод, возвращающий уникальный идентификатор сущности,
     * которой соответствует активность.
     * 
     * @return string Результат md5 от идентификатора сущности
     */
    public abstract function getActivityId();

    /**
     * 
     * @return \site\frontend\modules\som\modules\activity\models\api\Activity Модель активности, заполненная данными
     */
    public abstract function getActivityModel();

    /**
     * 
     * @return mixed true - модель удалена и надо удалить активность, false - модель есть и при необходимости, надо создать активность.
     */
    public abstract function getIsRemoved();
}
