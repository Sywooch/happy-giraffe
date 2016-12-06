<?php
namespace site\common\components;

/**
 * @author Никита
 * @date 06/12/16
 */
class ServiceStatusManager extends \CApplicationComponent
{
    public $statuses = [];

    public function isActive($service)
    {
        return isset($this->statuses[$service]) ? $this->statuses[$service] : false;
    }
}