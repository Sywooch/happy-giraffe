<?php

class Piwik extends CApplicationComponent
{
    public $token_auth;
    public $idSite;

    public function makeRequest($method, $period, $date, $segment = '')
    {
        $params = array(
            'module' => 'API',
            'format' => 'json',
            'token_auth' => $this->token_auth,
            'idSite' => $this->idSite,
            'method' => $method,
            'period' => $period,
            'date' => $date,
            'segment' => $segment,
        );

        $url = 'http://piwik.happy-giraffe.ru/?' . http_build_query($params);

        $response = file_get_contents($url);
        $json = CJSON::decode($response);
        return $json['value'];
    }

    public function getUniqueVisitors($period, $date, $segment = '')
    {
        return $this->makeRequest('VisitsSummary.getUniqueVisitors', $period, $date, $segment);
    }

    public function getPageViews($period, $date, $segment = '')
    {
        return $this->makeRequest('VisitsSummary.getActions', $period, $date, $segment);
    }
}