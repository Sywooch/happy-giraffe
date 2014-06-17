<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 03/06/14
 * Time: 09:36
 */

namespace site\frontend\modules\seo\components;

class YandexWebmaster extends \CComponent
{
    const TOKEN = 'f23957d6746d4a3fb8acb1cae4fb339c';

    /**
     * @var \RESTClient
     */
    public $client;

    public function __construct()
    {
        $this->client = new \RESTClient();
        $this->client->set_header('Authorization', 'OAuth ' . self::TOKEN);
    }
} 