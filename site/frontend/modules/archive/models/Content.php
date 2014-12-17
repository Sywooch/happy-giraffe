<?php

namespace site\frontend\modules\archive\models;

/**
 * Вспомогательная модель контента, для формирования архива и календаря записей
 *
 * @author Кирилл
 */
class Content extends \site\frontend\modules\posts\models\Content
{

    /**
     * 
     * @param string $className
     * @return \site\frontend\modules\archive\models\Content
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * Выбор записей за определённый день
     * 
     * @param int $date День в формате unix timestamp
     * @return \site\frontend\modules\archive\models\Content
     */
    public function byDay($date)
    {
        $month = date('m', $date);
        $year = date('Y', $date);
        $day = date('d', $date);
        
        $begin = mktime(0, 0, 0, $month, $day, $year);
        $end = mktime(23, 59, 59, $month, $day, $year);

        $this->getDbCriteria()->addBetweenCondition('dtimePublication', $begin, $end);
        
        return $this;
    }

}
