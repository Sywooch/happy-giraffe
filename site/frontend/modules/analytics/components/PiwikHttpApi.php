<?php
namespace site\frontend\modules\analytics\components;
use Guzzle\Http\Client;

/**
 * @author Никита
 * @date 26/01/15
 */

class PiwikHttpApi extends \CApplicationComponent
{
    public $baseUrl;
    public $idSite;
    public $token;

    public function getVisits($url)
    {
        $params = array(
            'period' => 'range',
            'date' => '2015-01-01,today',
            'segment' => 'pageUrl==' . $url,
        );
        return $this->makeRequest('VisitsSummary.getVisits', $params);
    }

    public function makeRequest($method, $params = array())
    {
        $client = new Client($this->baseUrl);
        $params = \CMap::mergeArray($this->getDefaultParams(), $params, compact('method'));
        $request = $client->get('? ' . http_build_query($params));
        $response = $request->send()->getBody(true);
        return \CJSON::decode($response);
    }

    protected function getDefaultParams()
    {
        return array(
            'module' => 'API',
            'idSite' => $this->idSite,
            'token_auth' => $this->token,
            'format' => 'json',
        );
    }
}