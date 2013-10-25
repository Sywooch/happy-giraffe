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
    const YOUTUBE_PROVIDER = 0;
    const VIMEO_PROVIDER = 1;
    const RUTUBE_PROVIDER = 2;

    public static $providers = array(
        self::YOUTUBE_PROVIDER => array(
            'regex' => '|https?://(www\.)?youtube.com/watch.*|i',
            'endpoint' => 'http://www.youtube.com/oembed',
        ),
        self::VIMEO_PROVIDER => array(
            'regex' => '|https?://(www\.)?vimeo.com/.*|i',
            'endpoint' => 'http://vimeo.com/api/oembed.json',
        ),
        self::RUTUBE_PROVIDER => array(
            'regex' => '|https?://(www\.)?rutube.ru/.*|i',
            'endpoint' => 'http://rutube.ru/api/oembed/',
        ),
    );

    public $data;

    public function __construct($url, $params = array(), $provider = null)
    {
        if ($provider === null)
            $provider = self::getProvider($url);

        if ($provider === false)
            throw new CException('Provider is not supported.');

        $data = $this->makeRequest($url, $this->getEndpoint($provider), $params);
        $this->data = CJSON::decode($data);
    }

    public static function getProvider($url)
    {
        foreach (self::$providers as $provider => $providerData) {
            if (preg_match($providerData['regex'], $url))
                return $provider;
        }
        return false;
    }

    protected function getEndpoint($provider)
    {
        return self::$providers[$provider]['endpoint'];
    }

    protected function makeRequest($url, $endpoint, $params)
    {

        $requestUrl = $endpoint . '/?' . http_build_query(CMap::mergeArray(array('url' => $url, 'format' => 'json'), $params));
        $ch = curl_init($requestUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($httpCode !== 200)
            throw new CException('Link is invalid.');
        return $response;
    }

    public function __get($name)
    {
        return isset($this->data[$name]) ? $this->data[$name] : parent::__get($name);
    }
}