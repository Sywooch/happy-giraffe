<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 10/09/14
 * Time: 14:58
 */

namespace site\common\behaviors;

class UrlBehavior extends \CActiveRecordBehavior
{
    public $route;
    public $params = array('id');

    public function getUrl($absolute = false)
    {
        if ($this->route === null) {
            throw new \CException('Route is not provided');
        }

        $params = array();
        foreach ($this->params as $k => $v) {
            $key = is_int($k) ? $v : $k;
            $params[$key] = $this->owner->getAttribute($v);
        }

        return $absolute ? \Yii::app()->createUrl($this->route, $params) : \Yii::app()->createAbsoluteUrl($this->route, $params);
    }
} 