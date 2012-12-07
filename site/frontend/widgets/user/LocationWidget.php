<?php
/**
 * Author: alexk984
 * Date: 29.02.12
 */
class LocationWidget extends UserCoreWidget
{
    public function init()
    {
        parent::init();
        $this->visible = !empty($this->user->address->country_id) || $this->user->id == Yii::app()->user->id;
    }
}
