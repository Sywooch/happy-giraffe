<?php

namespace site\frontend\components\api;

/**
 * Description of ApiComponent
 *
 * @author Кирилл
 */
class ApiComponent extends \CComponent
{

    public $baseUrl = false;
    public $cacheComponent = 'cache';

    public function init()
    {
        $this->baseUrl = rtrim($this->baseUrl, '/');
    }

    public function request($api, $action, $params = array())
    {
        $api = trim($api, '/');
        $action = trim($action, '/');
        $url = $this->baseUrl . '/' . $api . '/' . $action . '/';
        if (!is_string($params)) {
            $params = \HJSON::encode($params);
        }
        $context = stream_context_create(array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Content-Type: application/json',
                'content' => $params,
                'ignore_errors' => true,
            ),
        ));

        \Yii::trace('request(' . $url . ')', __CLASS__);
        $result = file_get_contents($url, $use_include_path = false, $context);
        if (YII_DEBUG && !self::isJSON()) {
            throw new \site\frontend\components\api\ApiException($result);
        }
        return $result;
    }

    public function getCache()
    {
        $cacheComponent = $this->cacheComponent;
        return \Yii::app()->$cacheComponent;
    }

    public static function isJSON($str)
    {
        if (is_string($string)) {
            $res = json_decode($string);
            return is_array($res) || is_object($res);
        }
        return false;
    }

}

?>
