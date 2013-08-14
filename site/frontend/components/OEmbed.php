<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 8/14/13
 * Time: 10:35 AM
 * To change this template use File | Settings | File Templates.
 */

class OEmbed extends CComponent
{
    public $data;

    public function __construct($url, $params = array())
    {
        $provider = Video::getProvider($url);

        if ($provider === false)
            return false;

        $data = $this->makeRequest($url, $this->getEndpoint($provider), $params);
        $this->data = CJSON::decode($data);
    }

    protected function getProvider($url)
    {
        foreach ($this->providers as $provider => $providerData) {
            if (preg_match($providerData['regex'], $url))
                return $provider;
        }
        return false;
    }

    protected function getEndpoint($provider)
    {
        return Video::$providers[$provider]['endpoint'];
    }

    protected function makeRequest($url, $endpoint, $params)
    {

        $requestUrl = $endpoint . '/?' . http_build_query(CMap::mergeArray(array('url' => $url, 'format' => 'json'), $params));
        $ch = curl_init($requestUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        return $httpCode == 200 ? $response : false;
    }
}