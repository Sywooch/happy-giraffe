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
    const MIN_SYMBOLS = 500;
    const MAX_SYMBOLS = 32000;
    const ORIGINAL_TEXTS_URL = 'https://webmaster.yandex.ru/api/v2/hosts/6286558/original-texts';

    /**
     * @var YandexWebmaster
     */
    public $api;

    /** @var \RESTClient  */
    public $client;

    private $patterns = array(
        'CommunityContent' => array(
            '#\/community\/(?:\d+)\/forum\/(?:\w+)\/(\d+)\/$#',
            '#\/user\/(?:\d+)\/blog\/post(\d+)\/$#',
        ),
        'CookRecipe' => array(
            '#\/cook\/(?:recipe|multivarka)\/(\d+)\/$#'
        ),
    );

    public function __construct()
    {
        $this->api = new YandexWebmaster();
        $this->client = new \RESTClient();
    }

    public function sync($page)
    {
        do {
            echo 'page ' . $page . "\n";
            $response = $this->api->client->get(self::ORIGINAL_TEXTS_URL, array('page' => $page));
            $xml = new \SimpleXMLElement($response);
            $count = count($xml->{'original-text'});
            foreach ($xml->{'original-text'} as $textElement) {
                $text = (string) $textElement->content;
                $model = SeoYandexOriginalText::model()->find('external_id = :id', array(
                    ':id' => $textElement->id,
                ));

                if ($model !== null) {
                    if ($model->entity_id !== null) {
                        continue;
                    }
                } else {
                    $model = new SeoYandexOriginalText();
                    $model->added = new \CDbExpression('NOW()');
                    $model->external_text = $text;
                    $model->external_id = $textElement->id;
                }

                try {
                    $url = $this->getUrlByText($text);
                    $id = $this->getIdByUrl($url);
                    list($entity, $entity_id) = $id;
                    $model->entity = $entity;
                    $model->entity_id = $entity_id;
                } catch (YandexOriginalTextException $e) {
                    echo $e->getMessage();
                }

                $model->save();
            }
            $page++;
        } while ($count > 0);
    }

    public function add(SeoYandexOriginalText &$model)
    {
        $length = strlen($model->full_text);
        if ($length < self::MIN_SYMBOLS || $length > self::MAX_SYMBOLS) {
            return $model->delete();
        }

        $xml = new \SimpleXMLElement('<xml/>');
        $root = $xml->addChild('original-text');
        $root->addChild('content', $model->full_text);
        $response = $this->api->client->post(self::ORIGINAL_TEXTS_URL, $xml->asXML());

        if ($this->api->client->status() != 201) {
            return false;
        }

        $responseXml = new \SimpleXMLElement($response);
        $model->added = new \CDbExpression('NOW()');
        $model->external_id = $responseXml->id;
        $model->external_text = $responseXml->text;
        return true;
    }

    protected function getIdByUrl($url)
    {
        $id = null;
        foreach ($this->patterns as $entity => $patterns) {
            foreach ($patterns as $pattern) {
                $c = preg_match($pattern, $url, $matches);
                if ($c > 0) {
                    $id = array($entity, $matches[1]);
                    break;
                }
            }
        }

        if ($id === null) {
            throw new YandexOriginalTextException("Не удалось получить ID  по URL:\n" . $url . "\n");
        }

        return $id;
    }

    protected function getUrlByText($text)
    {
        $rest = new \RESTClient();

        do {
            $response = $rest->get('http://xmlsearch.yandex.ru/xmlsearch', array(
                'user' => 'choojoy-work',
                'key' => '03.158930922:9aab9c26009a4a2f58f3db048ad0fb58',
                'query' => 'site:www.happy-giraffe.ru ' . $text,
                'sortby' => 'rlv',
            ));
            $xml = new \SimpleXMLElement($response);
            $hasError = isset($xml->response->error);
            $hasError = $hasError && $xml->response->error->attributes()->code != 15;
            if ($hasError) {
                var_dump($xml->response->error->attributes()->code);
                sleep(300);
            }
        } while($hasError);

        if (! isset($xml->response->results->grouping->group[0]))
        {
            echo "status:" . $rest->status() . "\n";
            var_dump($xml);
            throw new YandexOriginalTextException("Не удалось получить URL по тексту:\n" . $text . "\n");
        }

        $url = (string) $xml->response->results->grouping->group[0]->doc->url;
        return $url;
    }
}

class YandexOriginalTextException extends \CException {}