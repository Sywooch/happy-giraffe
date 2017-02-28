<?php

/**
 * @author Никита
 * @date 15/02/17
 */
class VkParser
{
    const PER_PAGE = 100;

    /**
     * @var \Guzzle\Http\Client
     */
    private $_guzzle;

    private $_codes;

    public function __construct()
    {
        include_once Yii::getPathOfAlias('site.frontend.vendor.simplehtmldom_1_5') . DIRECTORY_SEPARATOR . 'simple_html_dom.php';
        $this->_guzzle = new \Guzzle\Http\Client('https://api.vk.com/method/');
        $this->_codes = $this->getCountryCodes();
    }

    public function run()
    {

    }

    protected function getCities($countryId, $regionId)
    {
        return $this->getList('database.getCities', ['country_id' => $countryId, 'region_id' => $regionId, 'need_all' => 1]);
    }

    protected function getRegions($countryId)
    {
        return $this->getList('database.getRegions', ['country_id' => $countryId]);
    }

    protected function getCountries()
    {
        return $this->getList('database.getCountries', ['need_all' => 1]);
    }

    protected function getCountryCode($title)
    {
        return $this->_codes[$title];
    }

    protected function getCountryCodes()
    {
        $response = $this->_guzzle->get('https://vk.com/dev/country_codes')->send()->getBody(true);
        $doc = str_get_html(iconv('windows-1251', 'utf-8', $response));
        $codes = [];
        foreach ($doc->find('tr') as $i => $tr) {
            if ($tr->find('td')) {
                $codes[trim($tr->find('td', 1)->plaintext)] = $tr->find('td', 0)->plaintext;
            }
        }
        return $codes;
    }

    protected function getList($method, $params = [])
    {
        $offset = 0;
        $params['count'] = self::PER_PAGE;
        do {
            $response = $this->makeRequest($method, $params);
            $count = $response['response']['count'];
            $items = $response['response']['items'];
            foreach ($items as $item) {
                yield $item;
            }
            $offset += self::PER_PAGE;
            $params['offset'] = $offset;
        }
        while ($count > (count($items) + $offset - self::PER_PAGE));
    }

    protected function makeRequest($method, $params = [])
    {
        $params['v'] = '5.62';
        return CJSON::decode($this->_guzzle->get($method, null, ['query' => $params])->send()->getBody(true));
    }
}