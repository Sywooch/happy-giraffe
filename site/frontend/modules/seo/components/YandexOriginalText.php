<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 03/06/14
 * Time: 11:45
 */

namespace site\frontend\modules\seo\components;


use site\frontend\modules\seo\models\SeoYandexOriginalText;

class YandexOriginalText
{
    const ORIGINAL_TEXTS_URL = 'https://webmaster.yandex.ru/api/v2/hosts/6286558/original-texts';

    /**
     * @var YandexWebmaster
     */
    public $api;

    /** @var \RESTClient  */
    public $client;

    private $patterns = array(
        '#\/community\/(?:\d+)\/forum\/(?:\w+)\/(\d+)\/$#',
        '#\/user\/(?:\d+)\/blog\/post(\d+)\/$#',
    );

    public function __construct()
    {
        $this->api = new YandexWebmaster();
        $this->client = new \RESTClient();
    }

    public function sync()
    {
        $page = 0;
        do {
            $response = $this->api->client->get(self::ORIGINAL_TEXTS_URL, array('page' => $page));
            $xml = new \SimpleXMLElement($response);
            $count = count($xml->{'original-text'});
            foreach ($xml->{'original-text'} as $textElement) {
                $text = (string) $textElement->content;
                $url = $this->getUrlByText($text);
                $id = $this->getIdByUrl($url);

                $isAdded = SeoYandexOriginalText::model()->exists('external_id = :id', array(
                    ':id' => $textElement->id,
                ));

                if ($isAdded) {
                    continue;
                }

                $model = new SeoYandexOriginalText();
                $model->entity = 'CommunityContent';
                $model->entity_id = $id;
                $model->added = new \CDbExpression('NOW()');
                $model->text = $text;
                $model->external_id = $textElement->id;
                $model->save();
            }
        } while ($count > 0);
    }

    public function test(SeoYandexOriginalText &$model)
    {
        $model->priority = 99;
    }

    public function add(SeoYandexOriginalText &$model)
    {
        $xml = new \SimpleXMLElement('<xml/>');
        $root = $xml->addChild('original-text');
        $root->addChild('content', $model->full_text);
        $response = $this->api->client->post(self::ORIGINAL_TEXTS_URL, $xml->asXML());

        $responseXml = new \SimpleXMLElement($response);

        $model->added = new \CDbExpression('NOW()');
        $model->external_id = $responseXml->id;
        $model->external_text = $responseXml->text;

        return $this->api->client->status() == 201;
    }

    protected function getIdByUrl($url)
    {
        $id = null;
        foreach ($this->patterns as $pattern) {
            $c = preg_match($pattern, $url, $matches);
            if ($c > 0) {
                $id = $matches[1];
                break;
            }
        }

        if ($id === null) {
            throw new YandexOriginalTextException('Не удалось определить id поста по ссылке ' . $url);
        }

        return $id;
    }

    protected function getUrlByText($text)
    {
        $rest = new \RESTClient();
        $response = $rest->get('http://xmlsearch.yandex.ru/xmlsearch', array(
            'user' => 'choojoy-work',
            'key' => '03.158930922:9aab9c26009a4a2f58f3db048ad0fb58',
            'query' => 'site:www.happy-giraffe.ru ' . $text,
            'sortby' => 'rlv',
        ));
        $xml = new \SimpleXMLElement($response);
        $url = (string) $xml->response->results->grouping->group[0]->doc->url;
        return $url;
    }
}

class YandexOriginalTextException extends \CException {}