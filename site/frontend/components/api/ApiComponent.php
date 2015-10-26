<?php

namespace site\frontend\components\api;

/**
 * Description of ApiComponent
 *
 * @author Кирилл
 */
class ApiComponent extends \CComponent
{
    const RETRIES = 3;

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

        for ($i = 1; $i <= self::RETRIES; $i++) {
            $result = file_get_contents($url, $use_include_path = false, $context);

            if (YII_DEBUG && !self::isJSON($result)) {
                throw new \site\frontend\components\api\ApiException($result);
            }

            if (! empty($result)) {
                break;
            }
            sleep(pow(2, $i));
        }
        return $result;
    }

    public function getCache()
    {
        $cacheComponent = $this->cacheComponent;
        return \Yii::app()->$cacheComponent;
    }

    public static function isJSON($string)
    {
        if (is_string($string)) {
            $res = json_decode($string);
            return is_array($res) || is_object($res);
        }
        return false;
    }

}

?>
