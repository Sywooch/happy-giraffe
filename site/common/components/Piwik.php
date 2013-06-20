<?php

class Piwik extends CApplicationComponent
{
    public $accessToken;

    public function getCountByPageUrl($url)
    {
        define('PIWIK_INCLUDE_PATH', '/Users/mikita/Downloads/latest');
        define('PIWIK_USER_PATH', '/Users/mikita/Downloads/latest');
        define('PIWIK_ENABLE_DISPATCH', false);
        define('PIWIK_ENABLE_ERROR_HANDLER', false);
        define('PIWIK_ENABLE_SESSION_START', false);

        require_once PIWIK_INCLUDE_PATH . "/index.php";
        require_once PIWIK_INCLUDE_PATH . "/core/API/Request.php";

        Piwik_FrontController::getInstance()->init();

        $params = array(
            'method' => 'VisitsSummary.getUniqueVisitors',
            'idSite' => '1',
            'period' => 'range',
            'date' => '1970-01-01,today',
            'format' => 'json',
            'segment' => 'pageUrl==' . urlencode($url),
        );

        $request = new Piwik_API_Request(http_build_query($params));
        $result = $request->process();
        echo $result;
    }
}