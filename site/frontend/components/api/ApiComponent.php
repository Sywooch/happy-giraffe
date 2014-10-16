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
        if (!is_string($params))
            $params = \HJSON::encode($params);

        $context = stream_context_create(array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Content-Type: application/json',
                'content' => $params,
            ),
        ));

        \Yii::trace('request(' . $url . ')', __CLASS__);
        return file_get_contents($url, $use_include_path = false, $context);
    }

    public function getCache()
    {
        $cacheComponent = $this->cacheComponent;
        return \Yii::app()->$cacheComponent;
    }

}

?>
