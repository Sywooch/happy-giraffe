<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 25/09/14
 * Time: 01:16 PM
 */

namespace site\frontend\modules\photo\tests;


use Guzzle\Http\Client;
use Guzzle\Plugin\Cookie\CookieJar\FileCookieJar;
use Guzzle\Plugin\Cookie\CookiePlugin;

class ApiTest extends \PHPUnit_Framework_TestCase
{
    public function testAlbums()
    {
        date_default_timezone_set('Europe/Moscow');
        $cookiePlugin = new CookiePlugin(new FileCookieJar(\Yii::getPathOfAlias('site.common.data.test')));


        $client = new Client('http://www.virtual-giraffe.ru');
        $client->addSubscriber($cookiePlugin);

        $login = $client->post('/signup/login/default/', null, array(
            'LoginForm[email]' => 'nikita@happy-giraffe.ru',
            'LoginForm[password]' => '111111',
        ));

        $login->send();




        $request = $client->post('/api/photo/albums/create/', null, json_encode(array(
            'attributes' => array(
                'title' => 'Тестовый альбом',
                'description' => 'Тестовое описание',
            ),
        )));

        $response = $request->send()->getBody(true);

        var_dump($response);

        $response = json_decode($response);

        var_dump($response);
    }
}