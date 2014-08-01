<?php

/**
 * Расширенное поведение для работы с датой создания и датой обновления
 *
 * @author Кирилл
 */
class HTimestampBehavior extends CTimestampBehavior
{

    public function getUnixTimeByAttribute($attribute, $milliseconds = false)
    {
        return strtotime($this->owner->$attribute) * ($milliseconds ? 1000 : 1);
    }
    
    public function getPubUnixTime($milliseconds = false)
    {
        return $this->getUnixTimeByAttribute($this->createAttribute, $milliseconds = false);
    }

    public function getPubDate($format = 'Y-m-d\TH:i:sP')
    {
        return date($format, $this->pubUnixTime);
    }

}

?>
