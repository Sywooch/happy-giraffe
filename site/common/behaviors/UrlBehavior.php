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
    public $preparedUrl;
    public $route;
    public $params = array('id');

    public function getUrl($absolute = false)
    {
        if ($this->preparedUrl !== null) {
            return $this->normalizePreparedUrl($this->preparedUrl);
        }

        if ($this->route === null) {
            throw new \CException('Route is not provided');
        }

        $finalRoute = $this->normalizeRoute($this->route);
        $finalParams = $this->normalizeParams($this->params);

        return $absolute ? \Yii::app()->createUrl($finalRoute, $finalParams) : \Yii::app()->createAbsoluteUrl($finalRoute, $finalParams);
    }

    protected function normalizePreparedUrl($preparedUrl)
    {
        if (is_callable($preparedUrl)) {
            return call_user_func($preparedUrl, $this->owner);
        } elseif ($this->owner->getAttribute($preparedUrl) !== null) {
            return $this->owner->$preparedUrl;
        }
        return $preparedUrl;
    }

    protected function normalizeRoute($route)
    {
        return (is_callable($route)) ? call_user_func($route, $this->owner) : $route;
    }

    protected function normalizeParams($inputParams)
    {
        if (is_callable($inputParams)) {
            return call_user_func($inputParams, $this->owner);
        } else {
            $outputParams = array();
            foreach ($inputParams as $k => $v) {
                $key = is_int($k) ? $v : $k;
                $outputParams[$key] = $this->owner->getAttribute($v);
            }
            return $outputParams;
        }
    }
} 