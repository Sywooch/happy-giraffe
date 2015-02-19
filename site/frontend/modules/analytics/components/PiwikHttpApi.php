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
            'date' => '2015-02-13,yesterday',
            'segment' => 'pageUrl==' . $url,
        );
        $response = $this->makeRequest('VisitsSummary.getVisits', $params);
        return $response['value'];
    }

    public function makeRequest($method, $params = array())
    {
        $client = new Client($this->baseUrl);
        $params = \CMap::mergeArray($this->getDefaultParams(), $params, compact('method'));
        $request = $client->get('? ' . http_build_query($params));
        $response = $request->send()->getBody(true);
        return \CJSON::decode($response);
    }

    public function getTrackingCode()
    {
        return \Yii::app()->controller->renderPartial('application.modules.analytics.views.piwik', array(
            'idSite' => $this->idSite,
            'baseUrl' => $this->baseUrl,
        ), true);
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