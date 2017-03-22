<?php

namespace site\frontend\modules\geo2\components\vk;

/**
 * @author Никита
 * @date 15/02/17
 */
class Parser
{
    const PER_PAGE = 1000;
    const PAGINATION_INTERSECTION = 1;

    /**
     * @var \Guzzle\Http\Client
     */
    private $_guzzle;

    private $_codes;

    public function __construct()
    {
        include_once \Yii::getPathOfAlias('site.frontend.vendor.simplehtmldom_1_5') . DIRECTORY_SEPARATOR . 'simple_html_dom.php';
        $this->_guzzle = new \Guzzle\Http\Client('https://api.vk.com/method/');
        $this->_codes = $this->getCountryCodes();
    }

    public function getCities($countryId, $regionId = null)
    {
        $params = ['country_id' => $countryId, 'need_all' => 1];
        if ($regionId !== null) {
            $params['region_id'] = $regionId;
        }
        return $this->getList('database.getCities', $params);
    }

    public function getRegions($countryId)
    {
        return $this->getList('database.getRegions', ['country_id' => $countryId]);
    }

    public function getCountries()
    {
        return $this->getList('database.getCountries', ['need_all' => 1]);
    }

    public function getCountryCode($title)
    {
        return $this->_codes[$title];
    }

    protected function getCountryCodes()
    {
        $exclusions = [
            'Бонайре, Синт-Эстатиус и Саба' => 'BQ',
            'Беларусь' => 'BY',
            'Бруней-Даруссалам' => 'BN',
            'Буркина-Фасо' => 'BF',
            'Виргинские острова, Британские' => 'VG',
            'Виргинские острова, США' => 'VI',
            'Гернси' => 'GG',
            'Джерси' => 'JE',
            'Китай' => 'CN',
            'Конго' => 'CG',
            'Конго, демократическая республика' => 'CD',
            'Кот д`Ивуар' => 'CI',
            'Кыргызстан' => 'KG',
            'Кюрасао' => 'CW',
            'Македония' => 'MK',
            'Микронезия, федеративные штаты' => 'FM',
            'Молдова' => 'MD',
            'Объединенные Арабские Эмираты' => 'AE',
            'Остров Мэн' => 'IM',
            'Острова Кайман' => 'KY',
            'Острова Теркс и Кайкос' => 'TC',
            'Палестинская автономия' => 'PS',
            'Папуа - Новая Гвинея' => 'PG',
            'Питкерн' => 'PN',
            'Святая Елена' => 'SH',
            'Северная Корея' => 'KP',
            'Сейшелы' => 'SC',
            'Сент-Винсент' => 'VC',
            'Сент-Пьер и Микелон' => 'PM',
            'Синт-Мартен' => 'SX',
            'Сирийская Арабская Республика' => 'SY',
            'Тайвань' => 'TW',
            'Туркменистан' => 'TM',
            'Центрально-Африканская Республика' => 'CF',
            'Шпицберген и Ян Майен' => 'SJ',
            'Южная Корея' => 'KR',
            'Южно-Африканская Республика' => 'ZA',
            'Южный Судан' => 'SS',
        ];

        $response = $this->_guzzle->get('https://vk.com/dev/country_codes')->send()->getBody(true);
        $doc = str_get_html(iconv('windows-1251', 'utf-8', $response));
        $codes = [];
        foreach ($doc->find('tr') as $i => $tr) {
            if ($tr->find('td')) {
                $title = trim($tr->find('td', 1)->plaintext);
                $codes[$title] = $tr->find('td', 0)->plaintext;
            }
        }

        return array_merge($exclusions, $codes);
    }

    protected function getList($method, $params = [])
    {
        $offset = 0;
        $params['count'] = self::PER_PAGE;
        $result = [];
        do {
            var_dump($params);
            $oldItems = isset($items) ? $items : [];
            $response = $this->makeRequest($method, $params);
            $count = $response['response']['count'];
            $items = $response['response']['items'];
            $items = $this->filterDuplicates($items, $oldItems);
            $result = array_merge($result, $items);
            $offset += self::PER_PAGE - self::PAGINATION_INTERSECTION;
            $params['offset'] = $offset;
        }
        while ($count > (count($items) + $offset - self::PER_PAGE));
        return $result;
    }

    protected function filterDuplicates($items, $oldItems)
    {
        $intersection = array_map('unserialize', array_intersect(array_map('serialize', $items), array_map('serialize', $oldItems)));
        if ($intersection) {
            $intersection = array_map('unserialize', array_intersect(array_map('serialize', $items), array_map('serialize', $oldItems)));
            foreach (array_keys($intersection) as $key) {
                unset($items[$key]);
            }
        }
        return $items;
    }

    protected function makeRequest($method, $params = [])
    {
        $params['v'] = '5.63';
        do {
            $body = \CJSON::decode($this->_guzzle->get($method, null, ['query' => $params])->send()->getBody(true));
        } while (! isset($body['response']));
        return $body;
    }
}