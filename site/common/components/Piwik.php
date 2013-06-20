<?php

class Piwik extends CApplicationComponent
{
    public $accessToken;

    public function getCountByPageUrl($url)
    {
        $params = array(
            'module' => 'API',
            'method' => 'VisitsSummary.getUniqueVisitors',
            'idSite' => '1',
            'period' => 'month',
            'date' => 'today',
            'format' => 'json',
            'token_auth' => $this->accessToken,
            'segment' => 'pageUrl==' . urlencode($url),
        );

        $url = 'http://piwik.happy-giraffe.ru/?' . http_build_query($params);

        $response = file_get_contents($url);
        return $response;
    }
}